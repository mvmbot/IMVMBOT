async function main (interaction) {
    const {channel, guild} = interaction;

    const ticket_owner = await guild.members.fetch(channel.topic)
    .catch(err => console.log(err));

    interaction.reply('Closing Ticket...')
    .then(() => {
        channel.delete();
        if(ticket_owner) ticket_owner.send('Your Ticket has been closed');
    })

};

    module.exports = main;