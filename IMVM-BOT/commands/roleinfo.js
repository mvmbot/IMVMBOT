const { SlashCommandBuilder, MessageEmbed } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('roleinfo')
        .setDescription('Get role info from user')
        .addRoleOption(option => option.setName('role').setDescription('The role you want to get').setRequired(true)),
    async execute(interaction) {
        const { options, guild } = interaction;
        const role = options.getRole('role');
        const members = await guild.members.fetch({ cache: true });

        const name = role.name;
        const color = role.hexColor;
        const hoist = role.hoist;
        const pos = role.rawPosition;
        const mention = role.mentionable;

        let count = [...members.values()].filter(member => member.roles.cache.has(role.id)).length;

        const embed = new MessageEmbed()
            .setColor(color)
            .addFields(
                { name: 'Name', value: name },
                { name: 'Role ID', value: role.id },
                { name: 'Color', value: color },
                { name: 'Mentionable', value: mention },
                { name: 'Hoisted', value: hoist },
                { name: 'Role Position', value: pos },
                { name: 'Role Member Count', value: count }
            )
            .setTimestamp();

        await interaction.reply({ embeds: [embed], ephemeral: true });
    }
};
