// study.js
<<<<<<< HEAD
const { SlashCommandBuilder } = require('@discordjs/builders');
const schedule = require('node-schedule');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('study')
        .setDescription('Establece un tiempo de estudio')
        .addStringOption(option => 
            option.setName('time')
                .setDescription('Establece un temporizador de estudio (formato: HH:MM:SS)')
                .setRequired(true)),
    async execute(interaction) {
        const timeStr = interaction.options.getString('time');
        let timeParts = timeStr.split(':');

        if (timeParts.length === 3) {
            let date = new Date();
            date.setHours(date.getHours() + parseInt(timeParts[0]));
            date.setMinutes(date.getMinutes() + parseInt(timeParts[1]));
            date.setSeconds(date.getSeconds() + parseInt(timeParts[2]));

            if (!isNaN(date)) {
                schedule.scheduleJob(date, function(){
                    interaction.user.send(`¡Tiempo de estudio terminado!`);
                });
                await interaction.reply('¡Temporizador de estudio establecido!');
            } else {
                await interaction.reply('Ingresa un tiempo de estudio valido.');
            }
        } else {
            await interaction.reply('Ingresa un tiempo de estudio valido.');
        }
    },
=======
const schedule = require('node-schedule');
const { SlashCommandBuilder } = require('@discordjs/builders');

let studyStep = {}; // Guarda el paso del estudio para cada usuario

module.exports = {
  data: new SlashCommandBuilder()
    .setName('study')
    .setDescription('Set a study timer!')
    .addStringOption(option =>
      option.setName('time')
        .setDescription('How long do you want to study? (formato: HH:MM:SS)')
        .setRequired(true)),
  async execute(interaction) {
    const time = interaction.options.getString('time');
    let timeParts = time.split(':');

    if (timeParts.length === 3) {
      let date = new Date();
      date.setHours(date.getHours() + parseInt(timeParts[0]));
      date.setMinutes(date.getMinutes() + parseInt(timeParts[1]));
      date.setSeconds(date.getSeconds() + parseInt(timeParts[2]));

      if (!isNaN(date)) {
        schedule.scheduleJob(date, function(){
          interaction.user.send(`You already studied a lot, take a break!`);
        });
        await interaction.reply('Timer set!');
      } else {
        await interaction.reply('Please, choose a valid time!');
      }
    } else {
      await interaction.reply('Please, choose a valid time!');
    }
  },
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9
};