const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder, PermissionsBitField } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('clear')
        .setDescription('Clear messages.')
        .addIntegerOption(option =>
            option.setName('cantidad')
                .setDescription('Cantidad de mensajes a borrar.')
                .setRequired(true)),
    async execute(interaction) {

        if (!interaction.member.permissions.has(PermissionsBitField.Flags.ManageChannels)) {
            const embed = new EmbedBuilder()
            .setColor("Black")
            .setTitle("Error")
            .setDescription("❌ No tienes suficientes permisos")
            return await interaction.reply({ embeds: [embed], ephemeral: true });
        }

        const cantidad = interaction.options.getInteger('cantidad');

        if (cantidad < 1 || cantidad > 99) {
            const errorEmbed = new EmbedBuilder()
                .setColor('#FF0000')
                .setDescription('❌ | Debes ingresar un número entre 1 y 99.')
            return interaction.reply({ embeds: [errorEmbed], ephemeral: true });
        }

        const messages = await interaction.channel.bulkDelete(cantidad, true);

        const embed = new EmbedBuilder()
            .setColor('Green')
            .setDescription(`✅ | Se han borrado ${messages.size} mensajes.`);

        if (messages.size < cantidad) {
            embed.setDescription('❌ | Lo siento, no puedo borrar mensajes más antiguos de 14 días.');
        }

        await interaction.reply({ embeds: [embed], ephemeral: true });
    },
};