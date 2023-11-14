// rules.js

module.exports = client => {
    const user = message.mentions.users.first() || message.author;
    const rulesEmbed = new EmbedBuilder()
        .setColor([176, 92, 255])
        .setTitle('Normativa')
        .setURL('https://discord.com')
        .setAuthor({
            name: user.username,
            iconURL: user.avatarURL
        })
        .setDescription(rulesText)
        .setThumbnail(/*Aquí dentro va una foto a nuestra elección*/)
        .setImage(/*Foto a nuestra elección x2*/)
        .setTimeStamp()
        .setFooter({
            text: 'IMVM',
            iconURL: 'logo'
        });
    channel.send({embeds: [rulesEmbed]});
}