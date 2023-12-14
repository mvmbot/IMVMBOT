module.exports = client => {
    const channelId = '1163886058258305065';

    client.on('guildMemberAdd', member => {
        const message = `Welcome <@${member.id}> to the server!`;
        const channel = member.guild.channels.cache.get(channelId);
        channel.send(message);
    });

    client.on('guildMemberRemove', member => {
        const message = `See you later <@${member.id}>! Hope u come back!`;
        const channel = member.guild.channels.cache.get(channelId);
        channel.send(message);
    });
};