const { SlashCommandBuilder, EmbedBuilder, PermissionFlagsBits } = require("discord.js");

module.exports = {
    data: new SlashCommandBuilder()
        .setName("ban")
        .setDescription("Ban an user.")
        .setDefaultMemberPermissions(PermissionFlagsBits.BanMembers)
        .addUserOption(option =>
            option.setName("user")
                .setDescription("User who's getting banned.")
                .setRequired(true)
        )
        .addStringOption(option =>
            option.setName("reason")
                .setDescription("Reason to ban.")
        ),

    async execute(interaction) {
        const { channel, options } = interaction;

        const user = options.getUser("user");
        const reason = options.getString("reason") || "no reason";

        const member = await interaction.guild.members.fetch(user.id);

        const errEmbed = new EmbedBuilder()
            .setDescription(`You can't ban ${user.username}! He has a higher rol.`)
            .setColor(0xc72c3b);

        if (member.roles.highest.position >= interaction.member.roles.highest.position)
            return interaction.reply({ embeds: [errEmbed], ephemeral: true });

        await member.ban({ reason });

        const embed = new EmbedBuilder()
            .setTitle(":hammer: User banned")
            .setDescription(`${user} got banned by: ${reason}`)
            .setColor(0x5fb041)
            .setTimestamp()

        await interaction.reply({
            embeds: [embed]
        });
    }
}