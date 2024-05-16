//logout.js

const { SlashCommandBuilder } = require('@discordjs/builders');
const mysql = require('mysql');
require('dotenv').config();

const db = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
});

function checkIfUserHasToken(userId) {
  const query = `SELECT * FROM user_tokens WHERE user_id =? LIMIT 1`;
  return new Promise((resolve, reject) => {
    db.query(query, [userId], (err, result) => {
      if (err) {
        console.error(`Error checking if user has a token: ${err}`);
        reject(err);
      }
      resolve(result.length > 0);
    });
  });
}

async function deleteAccessTokenFromDatabase(userId) {
  const query = `DELETE FROM user_tokens WHERE user_id =?`;
  try {
    db.query(query, [userId]);
    console.log("Token de acceso eliminado de la base de datos.");
  } catch (err) {
    console.error(`Error deleting access token: ${err}`);
    throw err; 
  }
}

module.exports = {
  data: new SlashCommandBuilder()
  .setName('logout')
  .setDescription('Log out from Google Classroom'),
  async execute(interaction) {
    const discordUserId = interaction.user.id;

    try {
      const hasToken = await checkIfUserHasToken(discordUserId);
      if (!hasToken) {
        await interaction.reply({ content: 'No token found for this user.', ephemeral: true });
        return;
      }

      await deleteAccessTokenFromDatabase(discordUserId);
      await interaction.reply({ content: 'You have been logged out from Google Classroom.', ephemeral: true });
    } catch (error) {
      console.error(`An unexpected error occurred: ${error}`);
      await interaction.reply({ content: 'An error occurred. Please try again later.', ephemeral: true });
    }
  },
};