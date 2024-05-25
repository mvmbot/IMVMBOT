const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');
const mysql = require('mysql');
const { google } = require('googleapis');
require('dotenv').config();

// Crear pool de conexiones a la base de datos
const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT || 3306
});

db.getConnection((err, connection) => {
  if (err) {
    console.error('Error al conectar a la base de datos:', err);
  } else {
    console.log('Conexión a la base de datos establecida');
    connection.release();
  }
});

// Función para guardar el token de acceso en la base de datos
function saveAccessTokenToDatabase(userId, accessToken) {
  const query = `INSERT INTO user_tokens (user_id, access_token) VALUES (?,?) ON DUPLICATE KEY UPDATE access_token =?`;
  db.query(query, [userId, accessToken, accessToken], (err, result) => {
    if (err) {
      console.error('Error al guardar el token de acceso:', err);
      return;
    }
    console.log("Token de acceso guardado en la base de datos.");
  });
}

// Función para obtener el token de acceso de un usuario
function getUserToken(userId) {
  return new Promise((resolve, reject) => {
    const query = `SELECT access_token FROM user_tokens WHERE user_id =? LIMIT 1`;
    db.query(query, [userId], (err, result) => {
      if (err) {
        console.error('Error al recuperar el token de acceso del usuario:', err);
        return reject(err);
      }
      if (result.length === 0) {
        console.log(`No se encontró un token de acceso para el usuario ${userId}`);
        return resolve(null);
      }
      console.log(`Token de acceso recuperado para el usuario ${userId}`);
      resolve(result[0].access_token);
    });
  });
}

// Definición del comando slash
const coursesCommand = new SlashCommandBuilder()
  .setName('courses')
  .setDescription('Muestra los cursos de tu Google Classroom');

// Función para ejecutar el comando
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
    return interaction.reply({ content: 'Necesitas iniciar sesión primero usando el comando `/login`.', ephemeral: true });
  }

  console.log(`Token de acceso de Discord: ${discordAccessToken}`);

  // Configuración del cliente OAuth2 de Google
  const oauth2Client = new google.auth.OAuth2(
    process.env.GOOGLE_CLIENT_ID,
    process.env.GOOGLE_CLIENT_SECRET,
    process.env.GOOGLE_REDIRECT_URI
  );

  // Asignar el token de acceso de Discord al cliente OAuth2
  oauth2Client.setCredentials({ access_token: discordAccessToken });

  // Acceso a la API de Google Classroom
  const classroom = google.classroom({ version: 'v1', auth: oauth2Client });

  try {
    const response = await classroom.courses.list({
      pageSize: 10,
    });

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