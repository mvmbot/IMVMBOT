const { SlashCommandBuilder, EmbedBuilder, PermissionFlagsBits } = require("discord.js");

module.exports = {
    data: new SlashCommandBuilder()
        .setName("ban")
<<<<<<< HEAD
        .setDescription("Banea a un usuario.")
        .setDefaultMemberPermissions(PermissionFlagsBits.BanMembers)
        .addUserOption(option =>
            option.setName("user")
                .setDescription("Usuario a ser baneado.")
=======
        .setDescription("Ban an user.")
        .setDefaultMemberPermissions(PermissionFlagsBits.BanMembers)
        .addUserOption(option =>
            option.setName("user")
                .setDescription("User who's getting banned.")
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9
                .setRequired(true)
        )
        .addStringOption(option =>
            option.setName("reason")
<<<<<<< HEAD
                .setDescription("Razon del ban.")
=======
                .setDescription("Reason to ban.")
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9
        ),

    async execute(interaction) {
        const { channel, options } = interaction;

        const user = options.getUser("user");
<<<<<<< HEAD
        const reason = options.getString("razon") || "sin razon";
=======
        const reason = options.getString("reason") || "no reason";
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9

        const member = await interaction.guild.members.fetch(user.id);

        const errEmbed = new EmbedBuilder()
<<<<<<< HEAD
            .setDescription(`No puedes banear a ${user.username} el tiene un rol superior.`)
=======
            .setDescription(`You can't ban ${user.username}! He has a higher rol.`)
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9
            .setColor(0xc72c3b);

        if (member.roles.highest.position >= interaction.member.roles.highest.position)
            return interaction.reply({ embeds: [errEmbed], ephemeral: true });

        await member.ban({ reason });

        const embed = new EmbedBuilder()
<<<<<<< HEAD
            .setTitle(":hammer: Usuario baneado")
            .setDescription(`${user} ha sido baneado por: ${reason}`)
=======
            .setTitle(":hammer: User banned")
            .setDescription(`${user} got banned by: ${reason}`)
>>>>>>> 0247610e55543d82356cb24ca1a98fe305fffea9
            .setColor(0x5fb041)
            .setTimestamp()

        await interaction.reply({
            embeds: [embed]
        });
    }
}