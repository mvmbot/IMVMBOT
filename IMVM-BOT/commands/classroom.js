const { App } = require('@slack/bolt');
const { google } = require('googleapis');
const express = require('express');
const bodyParser = require('body-parser');

const app = express();
app.use(bodyParser.urlencoded({ extended: true }));

const port = process.env.PORT || 3000;

const slackApp = new App({
  token: process.env.SLACK_BOT_TOKEN,
  signingSecret: process.env.SLACK_SIGNING_SECRET
});

// Necesitarás autenticarte con Google Classroom API de alguna manera.
// Aquí es donde deberías hacerlo y asignar el objeto de autenticación a "auth".
const auth = null;

// Define tu comando slash '/classroom'
slackApp.command('/classroom', async ({ command, ack, say }) => {
  await ack();

  const classroom = google.classroom({ version: 'v1', auth });
  let response;

  // Maneja las diferentes opciones para tu comando slash
  switch (command.text) {
    case 'tasks':
      // Si el usuario escribe '/classroom tasks', muestra las tareas pendientes
      response = await classroom.courses.courseWork.list({
        courseId: 'your-course-id',
      });
      break;
    case 'classes':
      // Si el usuario escribe '/classroom classes', muestra las clases
      response = await classroom.courses.list();
      break;
    case 'join':
      // Si el usuario escribe '/classroom join', únete a una clase
      response = await classroom.invitations.create({
        requestBody: {
          userId: 'me',
          courseId: 'your-course-id',
        },
      });
      break;
    default:
      // Si el usuario escribe algo diferente, muestra un mensaje de error
      await say(`Sorry, I didn't understand that. Please enter 'tasks', 'classes', or 'join'.`);
      return;
  }

  // Muestra la respuesta de la API de Google Classroom
  await say(response.data);
});

// Inicia tu aplicación Slack
(async () => {
  await slackApp.start(port);
  console.log('⚡️ Bolt app is running!');
})();

// Inicia tu servidor Express
app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
