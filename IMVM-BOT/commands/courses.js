const { SlashCommandBuilder } = require('@discordjs/builders');
const { google } = require('googleapis');
const mysql = require('mysql');
const { EmbedBuilder } = require('discord.js');
require('dotenv').config();

// Configuración de conexión a la base de datos
const dbConfig = {
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  port: process.env.DB_PORT
};
const dbConnection = mysql.createConnection(dbConfig);

// Función para obtener los tokens del usuario
async function getTokens(userId) {
  return new Promise((resolve, reject) => {
    dbConnection.query('SELECT access_token, refresh_token FROM user_tokens WHERE user_id = ?', [userId], (error, results) => {
      if (error) {
        reject(error);
      } else {
        resolve(results[0]);
      }
    });
  });
}

// Función para guardar el nuevo token de acceso
async function saveAccessToken(userId, accessToken) {
  return new Promise((resolve, reject) => {
    dbConnection.query('UPDATE user_tokens SET access_token = ? WHERE user_id = ?', [accessToken, userId], (error, results) => {
      if (error) {
        reject(error);
      } else {
        resolve();
      }
    });
  });
}

const coursesCommand = new SlashCommandBuilder()
  .setName('courses')
  .setDescription('Muestra los cursos de Google Classroom en los que estás inscrito.');

async function execute(interaction) {
  const userId = interaction.user.id;
  
  try {
    const tokens = await getTokens(userId);
    
    if (!tokens || !tokens.access_token) {
      return interaction.reply({ content: 'Necesitas iniciar sesión primero usando el comando /login.', ephemeral: true });
    }
    
    const oauth2Client = new google.auth.OAuth2(
      process.env.GOOGLE_CLIENT_ID,
      process.env.GOOGLE_CLIENT_SECRET,
      process.env.GOOGLE_REDIRECT_URI
    );
    
    oauth2Client.setCredentials({
      access_token: tokens.access_token,
      refresh_token: tokens.refresh_token
    });

    // Verifica y renueva el token de acceso si es necesario
    oauth2Client.on('tokens', async (tokens) => {
      if (tokens.access_token) {
        await saveAccessToken(userId, tokens.access_token);
      }
    });

    // Refresca el token si está expirado o a punto de expirar
    const shouldRefresh = !tokens.access_token || oauth2Client.isTokenExpiring();
    if (shouldRefresh) {
      const { credentials } = await oauth2Client.refreshAccessToken();
      oauth2Client.setCredentials(credentials);
      await saveAccessToken(userId, credentials.access_token);
    }
    
    const classroom = google.classroom({ version: 'v1', auth: oauth2Client });
    const response = await classroom.courses.list({ pageSize: 10 });
    const courses = response.data.courses;
    
    if (!courses || courses.length === 0) {
      return interaction.reply({ content: 'No se encontraron cursos.', ephemeral: true });
    }
    
    const embed = new EmbedBuilder()
      .setTitle('Cursos Google Classroom')
      .setDescription(courses.map(course => `${course.name} (${course.id})`).join('\n'));
    
    interaction.reply({ embeds: [embed], ephemeral: false });
  } catch (error) {
    console.error('Error al recuperar los cursos:', error);
    if (error.code === 401) {
      interaction.reply({ content: 'Credenciales inválidas. Por favor, inicia sesión de nuevo usando el comando /login.', ephemeral: true });
    } else {
      interaction.reply({ content: 'Error recuperando los cursos.', ephemeral: true });
    }
  }
}

module.exports = { data: coursesCommand, execute };