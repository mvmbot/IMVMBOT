// logout.js

const { SlashCommandBuilder } = require('@discordjs/builders');
const mysql = require('mysql');
require('dotenv').config();

module.exports = {
  data: new SlashCommandBuilder()
    .setName('logout')
    .setDescription('Log out from Google Classroom'),
  async execute(interaction) {
    const userId = interaction.user.id;

    await interaction.reply({
      ephemeral: true,
      embeds: [
        {
          title: 'Google Classroom Logout',
          description: 'You are about to log out from Google Classroom. Please confirm by clicking the button below.',
          color: 0xFF0000,
          footer: {
            text: 'Your access token will be removed from our database.',
          },
        },
      ],
      components: [
        {
          type: 1, // Action Row
          components: [
            {
              type: 2, // Button
              style: 4, // Red color
              label: 'Confirm Logout',
              customId: 'confirm_logout',
            },
          ],
        },
      ],
    });

    const filter = (i) => i.customId === 'confirm_logout' && i.user.id === userId;
    const collector = interaction.channel.createMessageComponentCollector({ filter, time: 60000 });

    collector.on('collect', async (i) => {
      if (i.customId === 'confirm_logout') {
        removeAccessTokenFromDatabase(userId);
        await i.update({
          content: 'You have been logged out from Google Classroom and your token has been removed from the database.',
          embeds: [],
          components: [],
        });
        collector.stop();
      }
    });
  },
};

function removeAccessTokenFromDatabase(userId) {
  const connection = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_NAME,
  });

  console.log("Conexión: " + connection);
  console.log("USER ID: " + userId);

  connection.connect((err) => {
    if (err) {
      console.error('Error connecting to the database:', err);
      return;
    }
    console.log('Connected to the database.');
  });

  const query = 'DELETE FROM user_tokens WHERE user_id = ?';

  connection.query(query, [userId], (err, results) => {
    if (err) {
      console.error('Error removing access token:', err);
      return;
    }
    console.log('Access token removed for user ID:', userId);
  });

  connection.end();
}
