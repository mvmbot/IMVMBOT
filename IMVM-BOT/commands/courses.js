const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
const mysql = require('mysql');
const { EmbedBuilder, ActionRowBuilder, ButtonBuilder, ButtonStyle, StringSelectMenuBuilder } = require('discord.js');
require('dotenv').config();

// Database connection configuration
const dbConfig = {
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT
};
const dbConnection = mysql.createConnection(dbConfig);

// Function to get users tokens from the database
async function getTokens(userId) {
  return new Promise((resolve, reject) => {
    dbConnection.query('SELECT access_token, refresh_token FROM user_tokens WHERE user_id = ?', [userId], (error, results) => {
      if (error) {
        reject(error);
      } else {
        resolve(results[0]);
      }
    });
  });
}

// Function to save the new access token in the database
async function saveAccessToken(userId, accessToken) {
  return new Promise((resolve, reject) => {
    dbConnection.query('UPDATE user_tokens SET access_token = ? WHERE user_id = ?', [accessToken, userId], (error, results) => {
      if (error) {
        reject(error);
      } else {
        resolve();
      }
    });
  });
}

// Slash command for retrieving Google Classroom courses
const coursesCommand = new SlashCommandBuilder()
  .setName('courses')
  .setDescription('Muestra los cursos de Google Classroom en los que estás inscrito.');

// Function to execute the command
async function execute(interaction) {
  const userId = interaction.user.id;

  try {
    const tokens = await getTokens(userId);

    if (!tokens || !tokens.access_token) {
      return interaction.reply({ content: 'You need to log in first using the /login command.', ephemeral: true });
    }

    const oauth2Client = new google.auth.OAuth2(
      process.env.GOOGLE_CLIENT_ID,
      process.env.GOOGLE_CLIENT_SECRET,
      process.env.GOOGLE_REDIRECT_URI
    );

    oauth2Client.setCredentials({
      access_token: tokens.access_token,
      refresh_token: tokens.refresh_token
    });

    oauth2Client.on('tokens', async (tokens) => {
      if (tokens.access_token) {
        await saveAccessToken(userId, tokens.access_token);
      }
    });

    const shouldRefresh = !tokens.access_token || oauth2Client.isTokenExpiring();
    if (shouldRefresh) {
      const { credentials } = await oauth2Client.refreshAccessToken();
      oauth2Client.setCredentials(credentials);
      await saveAccessToken(userId, credentials.access_token);
    }

    const classroom = google.classroom({ version: 'v1', auth: oauth2Client });
    const response = await classroom.courses.list({ pageSize: 25 });
    const courses = response.data.courses;

    if (!courses || courses.length === 0) {
      return interaction.reply({ content: 'No courses found.', ephemeral: true });
    }

    const totalCourses = courses.length;
    const coursesPerPage = 8;
    const totalPages = Math.ceil(totalCourses / coursesPerPage);
    let currentPage = 1;
    let selectedCourse = null;

    const generateEmbed = (page, course = null) => {
      if (course) {
        return new EmbedBuilder()
          .setTitle(`${interaction.user.username}'s selected course`)
          .setDescription(`**${course.name}**\n*Course ID* — ${course.id}`);
      }

      const start = (page - 1) * coursesPerPage;
      const end = start + coursesPerPage;
      const paginatedCourses = courses.slice(start, end);

      return new EmbedBuilder()
        .setTitle(`${interaction.user.username}'s courses`)
        .setDescription(paginatedCourses.map(course => `**${course.name}**\n*Course ID* — ${course.id}`).join('\n\n'))
        .setFooter({ text: `Page ${page} of ${totalPages}` });
    };

    const generateComponents = (page, course = null) => {
      const components = [];
      if (course) {
        const buttons = new ActionRowBuilder()
          .addComponents(
            new ButtonBuilder()
              .setCustomId('viewAssignments')
              .setLabel('View Assignments')
              .setStyle(ButtonStyle.Primary),
            new ButtonBuilder()
              .setCustomId('back')
              .setLabel('Back')
              .setStyle(ButtonStyle.Primary)
          );
        components.push(buttons);
      } else {
        const start = (page - 1) * coursesPerPage;
        const end = start + coursesPerPage;
        const paginatedCourses = courses.slice(start, end);

        const selectMenu = new StringSelectMenuBuilder()
          .setCustomId('courseSelect')
          .setPlaceholder('Select a course')
          .addOptions(paginatedCourses.map(course => ({
            label: course.name,
            value: course.id
          })));

        components.push(new ActionRowBuilder().addComponents(selectMenu));
      }
      return components;
    };

    await interaction.reply({
      ephemeral: true,
      embeds: [generateEmbed(currentPage)],
      components: generateComponents(currentPage)
    });

    const filter = (i) => i.user.id === userId && ['first', 'previous', 'next', 'last', 'viewAssignments', 'courseSelect', 'back'].includes(i.customId);

    const collector = interaction.channel.createMessageComponentCollector({ filter, time: 60000 });

    collector.on('collect', async (i) => {
      try {
        if (i.customId === 'first') currentPage = 1;
        if (i.customId === 'previous') currentPage--;
        if (i.customId === 'next') currentPage++;
        if (i.customId === 'last') currentPage = totalPages;
        if (i.customId === 'courseSelect') {
          selectedCourse = courses.find(course => course.id === i.values[0]);
          await i.update({ embeds: [generateEmbed(currentPage, selectedCourse)], components: generateComponents(currentPage, selectedCourse) });
          return;
        }
        if (i.customId === 'viewAssignments') {
          await viewAssignments(i, oauth2Client, classroom, selectedCourse.id);
        }
        if (i.customId === 'back') {
          selectedCourse = null;
          await i.update({ embeds: [generateEmbed(currentPage)], components: generateComponents(currentPage) });
        }
      } catch (error) {
        console.error('Interaction handling error:', error);
        if (!i.replied && !i.deferred) {
          await i.reply({ content: 'An error occurred while processing your request.', ephemeral: true });
        }
      }
    });

    collector.on('end', async () => {
      await interaction.editReply({ components: [] });
    });

  } catch (error) {
    console.error('Error retrieving courses:', error);
    if (error.code === 401) {
      await interaction.reply({ content: 'Invalid credentials. Please log in again using the /login command.', ephemeral: true });
    } else {
      await interaction.reply({ content: 'Error retrieving courses.', ephemeral: true });
    }
  }
}

// Function to view assignments for a selected course
async function viewAssignments(interaction, oauth2Client, classroom, courseId) {
  try {
    const response = await classroom.courses.courseWork.list({ courseId });
    const assignments = response.data.courseWork;

    if (!assignments || assignments.length === 0) {
      await interaction.reply({ content: 'No assignments found for this course.', ephemeral: true });
    } else {
      const assignmentsList = assignments.map(assignment => {
        const dueDate = assignment.dueDate ? `${assignment.dueDate.year}-${assignment.dueDate.month}-${assignment.dueDate.day}` : 'No due date';
        return `**${assignment.title}**\n*Due:* ${dueDate}`;
      }).join('\n\n');
      const embed = new EmbedBuilder()
        .setTitle('Assignments')
        .setDescription(assignmentsList);
      const actionRow = new ActionRowBuilder()
        .addComponents(
          new ButtonBuilder()
            .setCustomId('back')
            .setLabel('Back')
            .setStyle(ButtonStyle.Primary)
        );
      await interaction.reply({ embeds: [embed], components: [actionRow], ephemeral: true });
    }
  } catch (error) {
    console.error('Error retrieving assignments:', error);
    if (!interaction.replied && !interaction.deferred) {
      await interaction.reply({ content: 'Error retrieving assignments.', ephemeral: true });
    }
  }
}

module.exports = {
  data: coursesCommand,
  execute
};
