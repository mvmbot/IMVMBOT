/*
 * File: lock
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const Discord = require("discord.js")

module.exports = {
  data: new Discord.SlashCommandBuilder()
    .setName("lock")
    .setDescription(`Bloquear un canal`)
    .addChannelOption((option) =>
      option
        .setName("canal")
        .setDescription(`El canal que quieres bloquear`)
        .addChannelTypes(Discord.ChannelType.GuildText)
        .setRequired(true)
    ),
  /**
   *
   * @param {ChatInputCommandInteraction} interaction
   */
  execute: async(interaction) => {
    if (
      !interaction.member.permissions.has(
        Discord.PermissionsBitField.Flags.ManageChannels
      )
    )
      return await interaction.reply({
        content: `:_: No tienes permisos de \`\`ManageChannels\`\` para usar el comando.`,
        ephemeral: true,
      });

    try {
      let channel = interaction.options.getChannel("canal");
      channel.permissionOverwrites.create(interaction.guild.id, {
        SendMessages: false,
      });

       interaction.reply({
        content: `:_: Canal bloqueado correctamente.`,
        ephemeral: true,
      });
    } catch (error) {
      return interaction.reply({
        content: `:_: Hubo un error al bloquear el canal.`,
        ephemeral: true,
      });
    }
  },
}