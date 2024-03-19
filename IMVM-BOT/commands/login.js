const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
const fs = require('fs');
const oauth2Client = new google.auth.OAuth2(process.env.GOOGLE_CLIENT_ID, process.env.GOOGLE_CLIENT_SECRET, process.env.GOOGLE_REDIRECT_URI);
require('dotenv').config();

module.exports = {
  data: new SlashCommandBuilder()
    .setName('login')
    .setDescription('Log in to Google Classroom'),
  async execute(interaction) {
    const authorizationUrl = oauth2Client.generateAuthUrl({
      access_type: 'offline',
      scope: ['https://www.googleapis.com/auth/classroom.courses.readonly', 'https://www.googleapis.com/auth/classroom.rosters.readonly'],
      redirect_uri: process.env.GOOGLE_REDIRECT_URI,
    });

    await interaction.reply({ content: `Please log in to Google Classroom by visiting this URL: \n\`\`\`${authorizationUrl}\`\`\`` });

    // Handle the redirect URI
    const code = interaction.options.getString('code');
    if (code) {
      try {
        const { tokens } = await oauth2Client.getToken(code);
        oauth2Client.setCredentials(tokens);
        await interaction.reply({ content: 'You have successfully logged in to Google Classroom!', ephemeral: true });
      } catch (error) {
        console.error(error);
        await interaction.reply({ content: 'There was an error logging in to Google Classroom. Please try again.', ephemeral: true });
      }
    }
  },
};