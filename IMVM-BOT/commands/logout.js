/*
 * File: logout
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Logout from Google 0Auth2
 */

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
        try {
          await removeAccessTokenFromDatabase(userId);
          await i.update({
            content: 'You have been logged out from Google Classroom and your token has been removed from the database. ✅',
            embeds: [],
            components: [],
          });
        } catch (error) {
          await i.update({
            content: 'There was an error while logging out. Please try again later.',
            embeds: [],
            components: [],
          });
        } finally {
          collector.stop();
        }
      }
    });
  },
};

async function removeAccessTokenFromDatabase(userId) {
  return new Promise((resolve, reject) => {
    const connection = mysql.createConnection({
      host: process.env.DB_HOST,
      user: process.env.DB_USER,
      password: process.env.DB_PASSWORD,
      database: process.env.DB_NAME,
    });

    connection.connect((err) => {
      if (err) {
        console.error('Error connecting to the database:', err);
        reject(err);
        return;
      }
      console.log('Connected to the database.');
    });

    const query = 'DELETE FROM user_tokens WHERE user_id = ?';

    connection.query(query, [userId], (err, results) => {
      if (err) {
        console.error('Error removing access token:', err);
        reject(err);
        return;
      }
      console.log('Access token removed for user ID:', userId);
      resolve();
    });

    connection.end((err) => {
      if (err) {
        console.error('Error closing the database connection:', err);
        reject(err);
        return;
      }
      console.log('Database connection closed.');
    });
  });
}