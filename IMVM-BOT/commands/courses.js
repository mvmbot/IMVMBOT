const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');
const mysql = require('mysql');
const { google } = require('googleapis');
require('dotenv').config();

const db = mysql.createConnection({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME
});

console.log('Conexión a la base de datos creada');

function saveAccessTokenToDatabase(userId, accessToken) {
  const query = `INSERT INTO users_tokens (user_id, access_token) VALUES (?,?) ON DUPLICATE KEY UPDATE access_token =?`;
  db.query(query, [userId, accessToken, accessToken], (err, result) => {
    if (err) throw err;
    console.log("Token de acceso guardado en la base de datos.");
  });
}

function getUserToken(userId) {
  return new Promise((resolve, reject) => {
    const query = `SELECT access_token FROM users_tokens WHERE user_id =? LIMIT 1`;
    db.query(query, [userId], (err, result) => {
      if (err) reject(err);
      console.log(`Token de acceso recuperado para el usuario ${userId}`);
      resolve(result[0].access_token);
    });
  });
}

const coursesCommand = new SlashCommandBuilder()
.setName('courses')
.setDescription('Muestra los cursos de tu Google Classroom');

async function execute(interaction) {
  const discordUserId = interaction.user.id;
  const discordAccessToken = await getUserToken(discordUserId);

  if (!discordAccessToken) {
    return interaction.reply({ content: 'You need to login first using `/login` command.', ephemeral: true });
  }

  console.log(`Token de acceso de Discord: ${discordAccessToken}`);

  const oauth2Client = new google.auth.OAuth2(
    process.env.GOOGLE_CLIENT_ID,
    process.env.GOOGLE_CLIENT_SECRET,
    process.env.GOOGLE_REDIRECT_URI
  );

  // Intercambio del token de acceso de Discord por uno de Google Classroom
  oauth2Client.setCredentials({ access_token: discordAccessToken });

  // Obtener el token de acceso de Google Classroom
  const { tokens } = await oauth2Client.getTokenInfo();
  const googleAccessToken = tokens.access_token;

  console.log(`Token de acceso de Google Classroom: ${googleAccessToken}`);

  const classroom = google.classroom('v1');

  try {
    const response = await classroom.courses.list({
      pageSize: 10,
    });

    const courses = response.data.courses;

    const embed = new MessageEmbed()
   .setTitle('CURSOS GCLASSROOM')
   .setDescription(courses.map(course => `${course.name} (${course.id})`).join('\n'));

    interaction.reply({ embeds: [embed] });
  } catch (error) {
    console.error(error);
    interaction.reply({ content: 'Error recuperando los cursos.', ephemeral: true });
  }
}

module.exports = { data: coursesCommand, execute };