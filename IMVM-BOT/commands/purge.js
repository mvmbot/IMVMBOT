/*
 * File: purge
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Delete a number of message that you choose.
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder, PermissionsBitField } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('purge')
        .setDescription('purge messages.')
        .addIntegerOption(option =>
            option.setName('amount')
                .setDescription('amount Of messages to delete.')
                .setRequired(true)),
    async execute(interaction) {

        if (!interaction.member.permissions.has(PermissionsBitField.Flags.ManageChannels)) {
            const embed = new EmbedBuilder()
            .setColor("Black")
            .setTitle("Error")
            .setDescription("❌ No perms")
            return await interaction.reply({ embeds: [embed], ephemeral: true });
        }

        const cantidad = interaction.options.getInteger('amount');

        if (cantidad < 1 || cantidad > 99) {
            const errorEmbed = new EmbedBuilder()
                .setColor('#FF0000')
                .setDescription('❌ | Only numbers 1-99.')
            return interaction.reply({ embeds: [errorEmbed], ephemeral: true });
        }

        const messages = await interaction.channel.bulkDelete(cantidad, true);

        const embed = new EmbedBuilder()
            .setColor('Green')
            .setDescription(`✅ | Purged messages ${messages.size} `);

        if (messages.size < cantidad) {
            embed.setDescription('❌ | Error: 14 days.');
        }

        await interaction.reply({ embeds: [embed], ephemeral: true });
    },
};