/*
 * File: ping
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const { EmbedBuilder } = require('discord.js');

ping = {
    data: {
        name: 'ping',
        description: 'Muestra ping del bot',
    },
    async execute(interaction) {
        const ping = interaction.client.ws.ping;

        const embed = new EmbedBuilder()
        .setTitle('¡pong!')
        .setDescription(`🏓`)
        .addFields({ name: 'Ping del Bot', value: `${ping} ms` })
        embed.setColor('#F8D64E');

    await interaction.reply({ embeds: [embed] });
    },
};
module.exports = ping