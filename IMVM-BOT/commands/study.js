// study.js
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
};