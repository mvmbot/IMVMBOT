const { SlashCommandBuilder, EmbedBuilder, PermissionFlagsBits } = require("discord.js");

module.exports = {
    data: new SlashCommandBuilder()
        .setName("ban")
        .setDescription("Banea a un usuario")
        .setDefaultMemberPermissions(PermissionFlagsBits.BanMembers)
        .addUserOption(option =>
            option.setName("user")
                .setDescription("Usuario a ser baneado.")
                .setRequired(true)
        )
        .addStringOption(option =>
            option.setName("reason")
                .setDescription("Razon del ban.")
        ),

    async execute(interaction) {
        const { channel, options } = interaction;

        const user = options.getUser("user");
        const reason = options.getString("razon") || "sin razon";

        const member = await interaction.guild.members.fetch(user.id);

        const errEmbed = new EmbedBuilder()
            .setDescription(`No puedes banear a ${user.username} el tiene un rol superior.`)
            .setColor(0xc72c3b);

        if (member.roles.highest.position >= interaction.member.roles.highest.position)
            return interaction.reply({ embeds: [errEmbed], ephemeral: true });

        await member.ban({ reason });

        const embed = new EmbedBuilder()
            .setTitle(":hammer: Usuario baneado")
            .setDescription(`${user} ha sido baneado por: ${reason}`)
            .setColor(0x5fb041)
            .setTimestamp()

        await interaction.reply({
            embeds: [embed]
        });
    }
}