const { SlashCommandBuilder, ComponentType } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('ticket')
        .setDescription('Opens a support ticket.'),
    async execute(interaction) {
        const ticketCategory = interaction.guild.channels.cache.get('1164951931089854555');

        if (!ticketCategory) {
            return await interaction.reply({
                content: 'Error: Ticket category not found.',
                ephemeral: true,
            });
        }

        const ticketChannel = await interaction.guild.channels.create({
            name: `${interaction.user.username}'s Ticket`,
            type: 'GUILD_TEXT',
            position: ticketCategory.position + 1,
            parent: ticketCategory.id,
            permissionOverwrites: [
                {
                    id: interaction.guild.roles.everyone,
                    deny: ['VIEW_CHANNEL'],
                },
                {
                    id: interaction.user.id,
                    allow: ['VIEW_CHANNEL', 'SEND_MESSAGES', 'READ_MESSAGE_HISTORY'],
                },
            ],
        });

        const ticketMessage = await ticketChannel.send({
            content: `Hello <@${interaction.user.id}>, welcome to your support ticket. Please describe your issue here.`,
            components: [
                new discord.MessageActionRow().addComponents(
                    new discord.MessageButton()
                        .setCustomId('close-ticket')
                        .setLabel('Close Ticket')
                        .setStyle('DANGER'),
                ),
            ],
        });

        await interaction.reply({
            content: 'Ticket created. Please check your DMs.',
            ephemeral: true,
        });

        const filter = (i) => i.user.id === interaction.user.id && i.isButton();

        const collector = ticketChannel.createMessageComponentCollector({
            filter,
            max: 1,
            time: 60000,
        });

        collector.on('collect', (i) => {
            if (i.customId === 'close-ticket') {
                ticketChannel.delete();
                ticketMessage.delete();
                i.reply({
                    content: 'Ticket closed.',
                    ephemeral: true,
                });
            }
        });

        collector.on('end', (c) => {
            if (c.size === 0) {
                ticketChannel.delete();
                ticketMessage.delete();
            }
        });
    },
};