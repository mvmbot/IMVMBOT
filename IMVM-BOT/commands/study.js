// study.js
const { SlashCommandBuilder } = require('@discordjs/builders');
const schedule = require('node-schedule');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('study')
        .setDescription('Set a study timer')
        .addStringOption(option => 
            option.setName('time')
                .setDescription('The time for the study timer (format: HH:MM:SS)')
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
                    interaction.user.send(`Study time is over!`);
                });
                await interaction.reply('Study timer set!');
            } else {
                await interaction.reply('Please enter a valid time.');
            }
        } else {
            await interaction.reply('Please enter a valid time.');
        }
    },
};