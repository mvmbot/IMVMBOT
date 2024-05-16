// logout.js

const { SlashCommandBuilder } = require('@discordjs/builders');
const mysql = require('mysql');
require('dotenv').config();

const db = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME
});

function deleteAccessTokenFromDatabase(userId) {
  const query = `DELETE FROM user_tokens WHERE user_id =?`;
  db.query(query, [userId], (err, result) => {
    if (err) throw err;
    console.log("Token de acceso eliminado de la base de datos.");
  });
}

module.exports = {
  data: new SlashCommandBuilder()
  .setName('logout')
  .setDescription('Log out from Google Classroom'),
  async execute(interaction) {
    const discordUserId = interaction.user.id;
    deleteAccessTokenFromDatabase(discordUserId);
    await interaction.reply({ content: 'You have been logged out from Google Classroom.', ephemeral: true });
  },
};