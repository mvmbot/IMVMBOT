const Discord = require('discord.js');

const guildTicketCategoryId = "";

async function main (interaction) {
  const {channel, guild} = interaction;
  const ticketType = interaction.values[0];

  const tickets = guild.channels.cache.filter(channel => channel.parentId === guildTicketCategoryId);
  
  //Comprueba primero si ya hay ticket
  if(tickets.some(ticket => ticket.topic === user.id)) return interaction.reply({content: 'Ya tienes un ticket abierto loquete', ephemeral: true})

  //Si no hay ticket creado, se crea
  interaction.reply({content: 'Creando ticket loquete', ephemeral: true})
    .then(() => {
      guild.channels.create({
        name: ticketType+'-'+user.username.slice(0, 25-ticketType.length),
        topic: user.id,
        type: Discord.ChannelType.GuildText,
        parent: guildTicketCategoryId,
        permissionOverwrites: [
          {id: interaction.guild.roles.everyone, deny: [Discord.PermissionBitField.Flags.ViewChannel]},
          {id: moderationRole, allow: [Discord.PermissionBitField.Flags.ViewChannel]},
          {id: interaction.user.id, allow: [Discord.PermissionBitField.Flags.ViewChannel]}
        ]
      }).then(channel => {
        interaction.editReply({content: `Ticket creado loquete ${channel}`});
        channel.send(`Bienvenido ${user}, \n\nAhora nos ponemos contigo loquete`);
      });
}
