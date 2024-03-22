const { SlashCommandBuilder, ButtonBuilder, ButtonStyle, ActionRowBuilder, EmbedBuilder } = require('discord.js');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('ticket')
    .setDescription('Create a new support ticket.')
    .addStringOption(option =>
      option.setName('issue')
        .setDescription('Describe tu error que quieres solucionar.')
        .setRequired(true)),
  async execute(interaction) {
    const ticketCategory = interaction.guild.channels.cache.get('1164951931089854555');
    if (!ticketCategory) {
      return await interaction.reply({
        content: 'Error: Ticket category not found.',
        ephemeral: true,
      });
    }

    const issue = interaction.options.getString('issue');

    const ticketChannel = await interaction.guild.channels.create({
      name: `${interaction.user.username}'s Ticket ${new Date().toISOString().slice(0, 10)}`,
      type: 'GUILD_TEXT',
      position: ticketCategory.position + 1,
      parent: ticketCategory.id,
      permissionOverwrites: [
        {
          id: interaction.guild.id,
          deny: ['VIEW_CHANNEL'],
        },
        {
          id: interaction.user.id,
          allow: ['VIEW_CHANNEL', 'SEND_MESSAGES', 'READ_MESSAGE_HISTORY'],
        },
        {
          id: '1164622765052145704',
          allow: ['VIEW_CHANNEL'],
        },
      ],
    });

    const supportEmbed = new EmbedBuilder()
      .setColor('#0099ff')
      .setTitle(`${interaction.user.username}'s Support Ticket`)
      .setDescription(`Hello <@${interaction.user.id}>, welcome to your support ticket.Please provide any additional information below. A support agent will be with you shortly.`)
      .addFields(
        {
          name: 'Issue',
          value: issue,
          inline: true,
        },
      )
      .setImage('https://cdn.discordapp.com/attachments/1054482794392338502/1220340746457059358/imvmbot-tickets.jpg?ex=660e95e2&is=65fc20e2&hm=2ab657eabf06475d91f889ff04c157670f534c4063a59caeb1ce0e0c032f5b9e&')
      .setFooter({ text: `Opened by ${interaction.user.username}`, iconURL: interaction.user.avatarURL() })
      .setTimestamp();

    const closeButton = new ButtonBuilder()
      .setCustomId('close-ticket')
      .setLabel('Close Ticket')
      .setStyle(ButtonStyle.Danger);

    const row = new ActionRowBuilder().addComponents(closeButton);

    await ticketChannel.send({
      content: `<@${interaction.user.id}>`,
      embeds: [supportEmbed],
      components: [row],
    });

    await interaction.reply({
      content: 'Ticket created. Please check your DMs.',
      ephemeral: true,
    });

    const collector = ticketChannel.createMessageComponentCollector({
      componentType: ComponentType.Button,
      time: 600000, // Timeout after 10 minutes
    });

    collector.on('collect', async (i) => {
      if (i.customId === 'close-ticket') {
        await i.update({
          embeds: [
            new EmbedBuilder()
              .setColor('#ff0000')
              .setTitle('Ticket Closed')
              .setDescription(`Ticket closed by <@${i.user.id}>.`)
              .setTimestamp(),
          ],
          components: [],
        });

        await ticketChannel.permissionOverwrites.edit(interaction.user, {
          VIEW_CHANNEL: false,
        });

        await ticketChannel.delete();

        await i.deferUpdate();
      }
    });

    collector.on('end', () => {
      console.log('Ticket collector ended.');
    });
  },
};