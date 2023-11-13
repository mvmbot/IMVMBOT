// remind.js
const schedule = require('node-schedule');
const { SlashCommandBuilder } = require('@discordjs/builders');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('remind')
    .setDescription('Establece un recordatorio!')
    .addStringOption(option =>
      option.setName('reminder')
        .setDescription('Recordatorio que quieres establecer')
        .setRequired(true))
    .addStringOption(option =>
      option.setName('date')
        .setDescription('La fecha en la que quieres que te lo recuerde (formato: DD-MM-AAAA HH:MM:SS)')
        .setRequired(true)),
  async execute(interaction) {
    const reminder = interaction.options.getString('reminder');
    let dateParts = interaction.options.getString('date').split(' ')[0].split('-');
    let timeParts = interaction.options.getString('date').split(' ')[1].split(':');

    if (dateParts.length === 3 && timeParts.length === 3) {
      let date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0], timeParts[0], timeParts[1], timeParts[2]);

      if (!isNaN(date)) {
        schedule.scheduleJob(date, function(){
          interaction.user.send(`Recordatorio: ${reminder}`);
        });
        await interaction.reply('Recordatorio establecido!');
      } else {
        await interaction.reply('Por favor, ingresa una fecha válida.');
      }
    } else {
      await interaction.reply('Por favor, ingresa una fecha válida.');
    }
  },
};