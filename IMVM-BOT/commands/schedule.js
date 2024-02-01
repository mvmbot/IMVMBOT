const { SlashCommandBuilder, EmbedBuilder, PermissionFlagsBits } = require("discord.js");

module.exports = {
    data: new SlashCommandBuilder()
        .setName('schedule')
        .setDescription('Show the MVMs class schedule for 2nd DAW'),
    async execute(interaction) {
        // Create EmbedBuilder
        const rulesEmbed = new EmbedBuilder()
            .setColor([176, 92, 255])
            .setTitle('Schedule')
            .setDescription('2nd DAW schedule')
            .setAuthor({
                iconURL: interaction.user.displayAvatarURL(),
                name: interaction.user.tag
            })
            .setImage(`https://cdn.discordapp.com/attachments/953234501897703434/1202647952099909733/photo.jpg?ex=65ce382f&is=65bbc32f&hm=8a142a9fb2e78a9e768a0d4863839c4d2609322c41b267f1d1f28f47d38a8fe8&`)
            .setTimestamp()
            .setURL('https://imvmbot.com/')
            .setFooter({
                text: 'By IMVM students', iconURL: 'https://cdn.discordapp.com/attachments/1152263348461781002/1161360242848829520/imvmbot-logo.png?ex=65789d82&is=65662882&hm=f656dbb05cf38c5b2c505d8eafa1408d18c6530cc88528b0870fc35a02441880&'
            });
        // Interaction with embed
        await interaction.reply({ embeds: [rulesEmbed] });
    },
};