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

// Function to get users tokens
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

// Function to save the new access token
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

const coursesCommand = new SlashCommandBuilder()
  .setName('courses')
  .setDescription('Muestra los cursos de Google Classroom en los que estás inscrito.');

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
    const response = await classroom.courses.list({ pageSize: 25 }); // Fetch more courses for pagination
    const courses = response.data.courses;
    
    if (!courses || courses.length === 0) {
      return interaction.reply({ content: 'No courses found.', ephemeral: true });
    }
    
    const totalCourses = courses.length;
    const coursesPerPage = 12;
    const totalPages = Math.ceil(totalCourses / coursesPerPage);
    let currentPage = 1;
    
    const generateEmbed = (page) => {
      const start = (page - 1) * coursesPerPage;
      const end = start + coursesPerPage;
      const paginatedCourses = courses.slice(start, end);

      return new EmbedBuilder()
        .setTitle(`${interaction.user.username}'s courses`)
        .setDescription(paginatedCourses.map(course => `**${course.name}**\n*course id* — ${course.id}`).join('\n\n'))
        .setFooter({ text: `Page ${page} of ${totalPages}` });
    };

    const generateComponents = (page) => {
      const actionRow = new ActionRowBuilder()
        .addComponents(
          new ButtonBuilder()
            .setCustomId('first')
            .setLabel('⏮️')
            .setStyle(ButtonStyle.Primary)
            .setDisabled(page === 1),
          new ButtonBuilder()
            .setCustomId('previous')
            .setLabel('◀️')
            .setStyle(ButtonStyle.Primary)
            .setDisabled(page === 1),
          new ButtonBuilder()
            .setCustomId('next')
            .setLabel('▶️')
            .setStyle(ButtonStyle.Primary)
            .setDisabled(page === totalPages),
          new ButtonBuilder()
            .setCustomId('last')
            .setLabel('⏭️')
            .setStyle(ButtonStyle.Primary)
            .setDisabled(page === totalPages)
        );

      return [actionRow];
    };

    await interaction.reply({
      embeds: [generateEmbed(currentPage)],
      components: generateComponents(currentPage)
    });

    const filter = (i) => i.user.id === userId && ['first', 'previous', 'next', 'last'].includes(i.customId);

    const collector = interaction.channel.createMessageComponentCollector({ filter, time: 60000 });

    collector.on('collect', async (i) => {
      if (i.customId === 'first') currentPage = 1;
      if (i.customId === 'previous') currentPage--;
      if (i.customId === 'next') currentPage++;
      if (i.customId === 'last') currentPage = totalPages;

      await i.update({ embeds: [generateEmbed(currentPage)], components: generateComponents(currentPage) });
    });

    collector.on('end', async () => {
      await interaction.editReply({ components: [] });
    });
    
  } catch (error) {
    console.error('Error retrieving courses:', error);
    if (error.code === 401) {
      interaction.reply({ content: 'Invalid credentials. Please log in again using the /login command.', ephemeral: true });
    } else {
      interaction.reply({ content: 'Error retrieving courses.', ephemeral: true });
    }
  }
}

module.exports = { data: coursesCommand, execute };