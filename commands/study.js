// study.js 
const schedule = require('node-schedule');
const { SlashCommandBuilder } = require('discord.js');

let studyStep = {}; // Guarda el paso del estudio para cada usuario

module.exports = function(client) {
  data: new SlashCommandBuilder()
  client.on('interactionCreate', async interaction => { 
    if (!interaction.isCommand()) return; // Ignora los mensajes de otros bots

    const { commandName } = interaction;

    if (commandName === 'study') {
      studyStep[interaction.user.id] = 1; // Inicia el proceso de estudio
      await interaction.reply('¿Cuánto tiempo quieres estudiar? (formato: HH:MM:SS)');
    } else if (studyStep[interaction.user.id] === 1) {
      let timeParts = interaction.options.getString('time').split(':');

      // Verifica que todas las partes necesarias están presentes
      if (timeParts.length === 3) {
        let date = new Date();
        date.setHours(date.getHours() + parseInt(timeParts[0]));
        date.setMinutes(date.getMinutes() + parseInt(timeParts[1]));
        date.setSeconds(date.getSeconds() + parseInt(timeParts[2]));

        if (!isNaN(date)) {
          schedule.scheduleJob(date, function(){
            // Verifica que el usuario exista antes de intentar enviar el mensaje
            if (client.users.cache.get(interaction.user.id)) {
              client.users.cache.get(interaction.user.id).send(`¡Tiempo de estudio terminado!`);
            }
          });
          await interaction.reply('¡Temporizador de estudio establecido!');
          delete studyStep[interaction.user.id]; // Elimina el paso de estudio para el usuario
        } else {
          await interaction.reply('Por favor, ingresa un tiempo válido.');
        }
      } else {
        await interaction.reply('Por favor, ingresa un tiempo válido.');
      }
    }
  });
};