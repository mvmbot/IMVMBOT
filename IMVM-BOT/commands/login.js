/*
 * File: login
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Login process to Google Classroom.
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
const mysql = require('mysql');
require('dotenv').config();

// Initialize OAuth2 client with Google credentials
const oauth2Client = new google.auth.OAuth2(
  process.env.GOOGLE_CLIENT_ID,
  process.env.GOOGLE_CLIENT_SECRET,
  process.env.GOOGLE_REDIRECT_URI
);

module.exports = {
  data: new SlashCommandBuilder()
    .setName('login')
    .setDescription('Log in to Google Classroom'),
  async execute(interaction) {
    const state = JSON.stringify({ discordUserId: interaction.user.id });

    // Generate the authorization URL for Google OAuth2
    const authorizationUrl = oauth2Client.generateAuthUrl({
      access_type: 'offline',
      scope: [
        'https://www.googleapis.com/auth/classroom.announcements',
        'https://www.googleapis.com/auth/classroom.courses',
        'https://www.googleapis.com/auth/classroom.coursework.me',
        'https://www.googleapis.com/auth/classroom.guardianlinks.me.readonly'
      ],
      state: state
    });

    // Send a reply to the user with the authorization URL
    await interaction.reply({
      ephemeral: true,
      embeds: [
        {
          title: 'Google Classroom Login',
          description: 'Please log in to Google Classroom by clicking the button below. You will be redirected to a web page to complete the login process.',
          fields: [
            {
              name: 'Authorization URL',
              value: `[Click here to Sign In](${authorizationUrl})`
            }
          ],
          color: 0x008000,
          footer: {
            text: 'You will be redirected to Google to authorize the IMVMBOT application.'
          },
          image: {
            url: 'https://cdn.discordapp.com/attachments/1054482794392338502/1219741630895100054/imvmbot-classroom.jpg',
          },
        },
      ],
    });

    // Filter messages from the user to capture the OAuth2 authorization code
    const filter = (m) => m.author.id === interaction.user.id;
    const collector = interaction.channel.createMessageCollector({ filter, time: 60000 });

    collector.on('collect', async (m) => {
      const code = m.content;

      // Exchange authorization code for access token
      const { tokens } = await oauth2Client.getToken(code);
      const accessToken = tokens.access_token;

      // Save the access token to the database
      saveAccessTokenToDatabase(interaction.user.id, accessToken);

      // Notify the user that the token has been saved
      await interaction.followUp('Access token saved in the database.');
      collector.stop();
    });
  },
};

// Function to save the access token to the database
function saveAccessTokenToDatabase(userId, accessToken) {
  const connection = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
  });

  connection.connect((err) => {
    if (err) {
      console.error('Error connecting to the database:', err);
      return;
    }
    console.log('Connected to the database.');
  });

  const query = 'INSERT INTO user_tokens (user_id, access_token) VALUES (?, ?) ON DUPLICATE KEY UPDATE access_token = ?';

  connection.query(query, [userId, accessToken, accessToken], (err, results) => {
    if (err) {
      console.error('Error saving access token:', err);
      return;
    }
    console.log('Access token saved for user ID:', userId);
  });

  connection.end();
}