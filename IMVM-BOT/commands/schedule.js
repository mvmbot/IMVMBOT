/*
 * File: schedule
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Command to show the DAW schedule 23/24
 */
const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('schedule')
        .setDescription('Muestra el horario de clases'),
    async execute(interaction) {
        const calendarEmbed = new EmbedBuilder()
            .setColor('#0099ff')
            .setTitle('Horario de Clases')
            .setDescription('Aquí tienes el horario de clases para 1DAW y 2DAW (23-24).')
            .addFields(
                { name: '1DAW - AA', value: 'Lunes\n08:00-09:00: SI [P1 o P2]\n09:00-10:00: SI [P1 o P2]\n10:00-11:00: BD [AA]\n11:30-12:30: LMSGI [MA]\n12:30-13:30: LMSGI [MA]\n13:30-14:30: TUT [AA]\n\nMartes\n08:00-09:00: \n09:00-10:00: FOL [FJ]\n10:00-11:00: LMSGI [MA]\n11:30-12:30: PRO [AA]\n12:30-13:30: PRO [AA]\n13:30-14:30: PRO [AA]\n\nMiércoles\n08:00-09:00: \n09:00-10:00: AIP [P1]\n10:00-11:00: FOL [FJ]\n11:30-12:30: BD [AA]\n12:30-13:30: BD [AA]\n13:30-14:30: \n\nJueves\n08:00-09:00: AIP [P1]\n09:00-10:00: \n10:00-11:00: PRO [AA]\n11:30-12:30: PRO [AA]\n12:30-13:30: SI [P1 o P2]\n13:30-14:30: SI [P1 o P2]\n\nViernes\n08:00-09:00: \n09:00-10:00: AIP [P1]\n10:00-11:00: PRO [AA]\n11:30-12:30: PRO [AA]\n12:30-13:30: BD [AA]\n13:30-14:30: BD [AA]', inline: true },
                { name: '2DAW - MM', value: 'Lunes\n15:00-16:00: DWEC [P2]\n16:00-17:00: DWES [MM]\n17:00-18:00: DWES [MM]\n18:30-19:30: DIW [P2]\n19:30-20:30: PROJ/DUAL [MM]\n\nMartes\n15:00-16:00: DWEC [P2]\n16:00-17:00: DWES [MM]\n17:00-18:00: DWES [MM]\n18:30-19:30: PROJ/DUAL [MM]\n19:30-20:30: PROJ/DUAL [MM]\n\nMiércoles\n15:00-16:00: ED [MM]\n16:00-17:00: ED [MM]\n17:00-18:00: DIW [P2]\n18:30-19:30: DIW [P2]\n19:30-20:30: PROJ/DUAL [MM]\n\nJueves\n15:00-16:00: DAW [MM]\n16:00-17:00: DAW [MM]\n17:00-18:00: TUT [MM]\n18:30-19:30: PROJ/DUAL [MM]\n19:30-20:30: PROJ/DUAL [MM]\n\nViernes\n15:00-16:00: DWEC [P2]\n16:00-17:00: DWEC [P2]\n17:00-18:00: PROJ/DUAL [MM]\n18:30-19:30: PROJ/DUAL [MM]\n19:30-20:30: PROJ/DUAL [MM]', inline: true }
            );

        await interaction.reply({ embeds: [calendarEmbed] });
    }
};