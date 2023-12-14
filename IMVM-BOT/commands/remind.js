// remind.js
const { SlashCommandBuilder } = require('@discordjs/builders');
const schedule = require('node-schedule');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('remind')
        .setDescription('Establece un recordatorio')
        .addStringOption(option => 
            option.setName('reminder')
                .setDescription('Recordatorio')
                .setRequired(true))
        .addStringOption(option => 
            option.setName('date')
                .setDescription('Fecha para el recordatorio (formato: DD-MM-YYYY HH:MM:SS)')
                .setRequired(true)),
    async execute(interaction) {
        const reminder = interaction.options.getString('reminder');
        const dateStr = interaction.options.getString('date');
        let dateParts = dateStr.split(' ')[0].split('-');
        let timeParts = dateStr.split(' ')[1].split(':');

        if (dateParts.length === 3 && timeParts.length === 3) {
            let date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0], timeParts[0], timeParts[1], timeParts[2]);

            if (!isNaN(date)) {
                schedule.scheduleJob(date, function(){
                    interaction.user.send(`Recordatorio: ${reminder}`);
                });
                await interaction.reply('¡Recordatorio establecido!');
            } else {
                await interaction.reply('Ingresa una fecha valida.');
            }
        } else {
            await interaction.reply('Ingresa una fecha valida.');
        }
    },
};