async function main (interaction) {
    const {channel, guild} = interaction;

    const ticket_owner = await guild.members.fetch(channel.topic)
    .catch(err => console.log(err));

    interaction.reply('Cerrando su ticket')
    .then(() => {
        channel.delete();
        if(ticket_owner) ticket_owner.send('Su ticket ha sido cerrado');
    })

};

    module.exports = main;