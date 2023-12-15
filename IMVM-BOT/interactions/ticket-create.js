const Discord = require('discord.js');

const guildTicketCategoryId = '1164951931089854555';
const moderationRole = '1164622765052145704';

const ticketCloseButton = new Discord.ActionRowBuilder().addComponents(
    new Discord.ButtonBuilder()
    .setCustomId('ticket-close')
    .setLabel('Close Ticket')
    .setStyle('2')
    .setEmoji('🔒')
)

async function main (interaction) {
    const {user, guild} = interaction;
    const ticketType = interaction.values[0];

    const tickets = guild.channels.cache.filter(channel => channel.parentId === guildTicketCategoryId);
    if(tickets.some(ticket => ticket.topic === user.id)) return interaction.reply({content: 'You have already One ticket open.', ephemeral: true})

    // Creacion de ticket
    interaction.reply({content: 'Your ticket is creating...', ephemeral: true})
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
            interaction.editReply({content: `- Your ticket has been created: ${channel}`});

            channel.send({
                content: `<@&1137114110270656582> Welcome ${user},\n\nStaff is contacting you soon...`,
                components: [ticketCloseButton]
            });
        });
        
    });

};

module.exports = main;