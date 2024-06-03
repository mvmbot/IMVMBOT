/*
 * File: ticket-create
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Open a new ticket
 */

const Discord = require('discord.js');

const guildTicketCategoryId = '1164951931089854555';
const moderationRole = '1164622765052145704';

const ticketCloseButton = new Discord.ActionRowBuilder().addComponents(
    new Discord.ButtonBuilder()
    .setCustomId('ticket-close')
    .setLabel('Close Ticket')
    .setStyle('2')
    .setEmoji('🔒'),

    new Discord.ButtonBuilder()
    .setEmoji('📑')
    .setStyle('2')
    .setCustomId('transcript')
)

async function main (interaction) {
    const {user, guild} = interaction;
    const ticketType = interaction.values[0];

    const tickets = guild.channels.cache.filter(channel => channel.parentId === guildTicketCategoryId);
    if(tickets.some(ticket => ticket.topic === user.id)) return interaction.reply({content: 'You have an open ticket!', ephemeral: true})

	const imageUrl = 'https://cdn.discordapp.com/attachments/1054482794392338502/1247137119160242298/imvmbot-tickets.jpg'

    const embed = {
        title: 'Ticket System',
        description: ` Welcome${user},\n\nThe staff will contact you soon`,
		color: 0x5BFF8A,
		image: { url: imageUrl }
    }
    // Creacion de ticket
    interaction.reply({content: 'Your ticket is being created...', ephemeral: true})
    .then(() => {
        guild.channels.create({
            name: ticketType+'-'+user.username.slice(0, 25-ticketType.length),
            topic: user.id,
            type: Discord.ChannelType.GuildText,
            parent: guildTicketCategoryId,
            permissionOverwrites: [
                {id: interaction.guild.roles.everyone, deny: [Discord.PermissionsBitField.Flags.ViewChannel]},
                {id: moderationRole, allow: [Discord.PermissionsBitField.Flags.ViewChannel]},
                {id: interaction.user.id, allow: [Discord.PermissionsBitField.Flags.ViewChannel, Discord.PermissionsBitField.Flags.SendMessages]},
                      ]
        }).then(channel => {
            interaction.editReply({content: `- Ticket created in: ${channel}`});

            channel.send({
                content: `<@&1137114110270656582>`,
                embeds: [embed],
                components: [ticketCloseButton]
            });
        });
        
    });

};

module.exports = main;