// login.js

const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
const mysql = require('mysql');
require('dotenv').config();

const connection = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME
});

const oauth2Client = new google.auth.OAuth2(
  process.env.GOOGLE_CLIENT_ID,
  process.env.GOOGLE_CLIENT_SECRET,
  process.env.GOOGLE_REDIRECT_URI
);

function saveAccessTokenToDatabase(userId, accessToken) {
  const query = "INSERT INTO user_tokens (user_id, access_token) VALUES (?, ?)";
  connection.query(query, [userId, accessToken], (error, results, fields) => {
    if (error) {
      console.error(error);
    } else {
      console.log("Token de acceso guardado en la base de datos.");
    }
  });
}

module.exports = {
  data: new SlashCommandBuilder()
    .setName('login')
    .setDescription('Log in to Google Classroom'),
  async execute(interaction) {
    const authorizationUrl = oauth2Client.generateAuthUrl({
      access_type: 'offline',
      scope: [
        'https://www.googleapis.com/auth/classroom.courses.readonly',
        'https://www.googleapis.com/auth/classroom.rosters.readonly'
      ],
    });

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

    const filter = (m) => m.author.id === interaction.user.id;
    const collector = interaction.channel.createMessageCollector({ filter, time: 60000 });

    collector.on('collect', async (m) => {
      const code = m.content;
      const { tokens } = await oauth2Client.getToken(code);
      const accessToken = tokens.access_token;

      saveAccessTokenToDatabase(interaction.user.id, accessToken);

      await interaction.followUp('Token de acceso guardado en la base de datos.');
      collector.stop();
    });

    collector.on('end', (collected, reason) => {
      if (reason === 'time') {
        interaction.followUp('Tiempo de espera agotado. Por favor, intenta de nuevo.');
      }
    });
  },
};