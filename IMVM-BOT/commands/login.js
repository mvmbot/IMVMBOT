const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
require('dotenv').config();

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
  },
};
