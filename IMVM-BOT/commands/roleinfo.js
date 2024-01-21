const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
    .setName('roleinfo')
    .setDescription('Get role info from user')
    .addRoleOption(option => option.setName ('role').setDescription('The role you want to get').setRequired(true)),
    async execute (interaction) {
        const {options, guild } = interaction;
        const role = options.getRole('role');
        const member = await guild.memebers.fetch();

        const name = role.name;
        const color = role.color;
        const icon = role.iconURL();
        const hoist = role.hoist;
        const pos = role.rawPosition;
        const mention = role.mentionable;

        let count = [];

        await member.forEach(async member => {
            if (member._roles.includes(id)) count++;
        });

        const embed = new EmbedBuilder()
        .setColor('DarkPurple')
        .setThumbnail(icon)
        .addFields({ name: `Name`, value: `${name}`})
        .addFields({ name: `Role ID`, value: `${id}`})
        .addFields({ name: `Color`, value: `${color}`})
        .addFields({ name: `Mentionable`, value: `${mention}`})
        .addFields({ name: `Hoisted`, value: `${hoist}`})
        .addFields({ name: `Role Position`, value: `${pos}`})
        .addFields({ name: `Role Member Count`, value: `${count}`})
        .addFields({ name: `Role Info`})
        .setTimestamp()

        await interaction.reply({ embeds: [embed], ephemeral: true });
    }
}