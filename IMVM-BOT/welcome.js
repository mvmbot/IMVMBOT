module.exports = client => {
    const channelId = '1163886058258305065';

    client.on('guildMemberAdd', member => {
        const message = `¡Bienvenido <@${member.id}> al servidor!`;
        const channel = member.guild.channels.cache.get(channelId);
        channel.send(message);
    });

    client.on('guildMemberRemove', member => {
        const message = `¡Adiós <@${member.id}>! ¡Esperamos verte de nuevo!`;
        const channel = member.guild.channels.cache.get(channelId);
        channel.send(message);
    });
};