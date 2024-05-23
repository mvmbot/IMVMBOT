/*
 * File: mute
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const {
    ChatInputCommandInteraction,
    SlashCommandBuilder,
    EmbedBuilder,
    PermissionFlagsBits,
  } = require("discord.js");

  module.exports = {
    data: new SlashCommandBuilder()
      .setName("mute")
      .setDescription("Mutea a un usuario")
      .addUserOption((option) =>
        option
          .setName(`target`)
          .setDescription(`user to mute`)
          .setRequired(true)
      )
      .addIntegerOption((option) =>
        option
          .setName(`tiempo`)
          .setDescription(`El tiempo maximo son 10.000 minutos`)
          .setRequired(true)
      )
      .addStringOption((option) =>
        option.setName(`razon`).setDescription(`Razon del timeout`)
        .setRequired(true)
      )
      .setDefaultMemberPermissions(PermissionFlagsBits.KickMembers),
    /**
     *
     * @param {ChatInputCommandInteraction} interaction
     */
    async execute(interaction, client) {
      const user = interaction.options.getUser(`target`);
      const tiempo = interaction.options.getInteger(`tiempo`);
      const { guild } = interaction;

      let razon = interaction.options.getString(`razon`);
      const member = await interaction.guild.members
        .fetch(user.id)
        .catch(console.error);

      if (
        member.roles.highest.position >= interaction.member.roles.highest.postion
      )
        return interaction.reply({
          content: `Dont timeout an supervisor`,
          ephemeral: true,
        });

      if (tiempo > 10000)
        return interaction.reply({
          content: `max is 10.000 minutes`,
          ephemeral: true,
        });

      const embed = new EmbedBuilder()
        .setAuthor({
          name: `${guild.name}`,
          iconURL: `${
            guild.iconURL({ dynamic: true }) ||
            "https://cdn.discordapp.com/attachments/1053464482095050803/1053464952607875072/PRywUXcqg0v5DD6s7C3LyQ.png"
          }`,
        })
        .setTitle(`${user.tag} got a timeout`)
        .setColor(`#ff0000`)
        .setTimestamp()
        .setThumbnail(`${user.displayAvatarURL({ dynamic: true })}`)
        .addFields(
          { name: `Razon`, value: `${razon}`, inline: true },
          { name: `Tiempo`, value: `${tiempo}`, inline: true }
        );

      await member.timeout(tiempo * 60 * 1000, razon).catch(console.error);

      interaction.reply({ embeds: [embed] });
    },
  };