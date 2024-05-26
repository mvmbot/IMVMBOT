const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');
const mysql = require('mysql2/promise');
const { google } = require('googleapis');
require('dotenv');

const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT,
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

async function getUserToken(userId) {
  try {
    const [rows] = await db.query('SELECT access_token FROM user_tokens WHERE user_id =? LIMIT 1', [userId]);
    if (rows.length === 0) {
      console.log(`No se encontró un token de acceso para el usuario ${userId}`);
      return null;
    }
    console.log(`Token de acceso recuperado para el usuario ${userId}`);
    return rows[0].access_token;
  } catch (err) {
    console.error('Error al recuperar el token de acceso del usuario:', err);
    throw err;
  }
}

const coursesCommand = new SlashCommandBuilder()
.setName('courses')
.setDescription('Muestra los cursos de tu Google Classroom');

async function execute(interaction) {
  const discordUserId = interaction.user.id;
  let discordAccessToken;

  try {
    discordAccessToken = await getUserToken(discordUserId);
  } catch (error) {
    console.error('Error al obtener el token de acceso del usuario:', error);
    return interaction.reply({ content: 'Error al obtener tu token de acceso.', ephemeral: true });
  }

  if (!discordAccessToken) {
    return interaction.reply({ content: 'Necesitas iniciar sesión primero usando el comando /login.', ephemeral: true });
  }

  console.log(`Token de acceso de Discord: ${discordAccessToken}`);

  const oauth2Client = new google.auth.OAuth2(
    process.env.GOOGLE_CLIENT_ID,
    process.env.GOOGLE_CLIENT_SECRET,
    process.env.GOOGLE_REDIRECT_URI
  );

  oauth2Client.setCredentials({ access_token: discordAccessToken });

  const classroom = google.classroom({ version: 'v1', auth: oauth2Client });

  try {
    const response = await classroom.courses.list({ pageSize: 10 });
    const courses = response.data.courses;

    if (!courses || courses.length === 0) {
      return interaction.reply({ content: 'No se encontraron cursos.', ephemeral: true });
    }

    const embed = new MessageEmbed()
    .setTitle('CURSOS GCLASSROOM')
    .setDescription(courses.map(course => `${course.name} (${course.id})`).join('\n'));

    interaction.reply({ embeds: [embed] });
  } catch (error) {
    console.error('Error al recuperar los cursos:', error);
    interaction.reply({ content: 'Error recuperando los cursos.', ephemeral: true });
  }
}

module.exports = { data: coursesCommand, execute };
