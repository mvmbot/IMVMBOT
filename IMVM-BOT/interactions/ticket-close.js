/*
 * File: ticket-close
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Close the ticket
 */

async function main (interaction) {
    const {channel, guild} = interaction;

    const ticket_owner = await guild.members.fetch(channel.topic)
    .catch(err => console.log(err));

    interaction.reply('Closing ticket...')
    .then(() => {
        channel.delete();
        if(ticket_owner) ticket_owner.send('Your ticket has been closed');
    })

};

    module.exports = main;