const { EmbedBuilder,AttachmentBuilder, ChannelType, PermissionsBitField, ActionRowBuilder, ButtonBuilder, ButtonStyle, ComponentType, ModalBuilder,TextInputBuilder, TextInputStyle, StringSelectMenuBuilder, Events, GatewayIntentBits, Partials  } = require('discord.js')
    const { createTranscript } = require('discord-html-transcripts')

async function main (interaction) {
  const { customId, guild, channel } = interaction;

    if (!interaction.member.permissions.has(PermissionsBitField.Flags.ManageMessages)) return await interaction.reply({ content: 'No cuentas con el permiso (Manejar mensajes) para realizar esta accion!', ephermal: true});
    await interaction.reply({ content: `Realizando tu transcript... 🟡`});
const posChannel = guild.channels.cache.find(c =>
        c.topic
      );
    const transcript = await createTranscript(channel, {
        limit: -1,
        returnBuffer: false,
        filename: `ticket-${posChannel}.html`,
      });
      const e = interaction.guild.channels.cache.get("1164953382327439432")
      const transcriptEmbed = new EmbedBuilder()
      .setAuthor({ name: `${interaction.guild.name}'s Transcript`, iconURL: guild.iconURL() })
      .addFields(
        {name: `Transcript hecho por:`, value: `${interaction.user.tag}`}
      )
      .setColor('Red')
      .setTimestamp()
      .setThumbnail(interaction.guild.iconURL())
      .setFooter({ text: `${interaction.guild.name}'s Ticket` })
             
      await interaction.editReply({ content: `El transcript ha sido enviado a ${e}`})
       
      await e.send({
        embeds: [transcriptEmbed],
        files: [transcript],

      }).catch(err => console.log(err))
    };

module.exports = main