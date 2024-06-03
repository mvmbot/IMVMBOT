/*
 * File: lock
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Lock any channel from your Discord Server.
 */

const Discord = require("discord.js")

module.exports = {
  data: new Discord.SlashCommandBuilder()
    .setName("lock")
    .setDescription(`Bloquear un canal`)
    .addChannelOption((option) =>
      option
        .setName("canal")
        .setDescription(`Selecciona canal que quieras bloquear`)
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
        content: `:_: You do not have permissions \`\`ManageChannels\`\` to use the command.`,
        ephemeral: true,
      });

    try {
      let channel = interaction.options.getChannel("canal");
      channel.permissionOverwrites.create(interaction.guild.id, {
        SendMessages: false,
      });

       interaction.reply({
        content: `:_: Channel blocked successfully.`,
        ephemeral: true,
      });
    } catch (error) {
      return interaction.reply({
        content: `:_: There was an error blocking the channel.`,
        ephemeral: true,
      });
    }
  },
}