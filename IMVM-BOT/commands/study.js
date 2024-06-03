/*
 * File: study
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Create a study timer and send you a private message when it ends.
 */

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
};