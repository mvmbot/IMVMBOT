const Discord = require('discord.js');
const welcome = require('./welcome.js');
const remind = require('./remind.js')
const study = require('./study.js');
const { Client, IntentsBitField } = require('discord.js');
require('dotenv').config();

const client = new Client({
  intents: [
    IntentsBitField.Flags.Guilds,
    IntentsBitField.Flags.GuildMembers,
    IntentsBitField.Flags.GuildMessages,
    IntentsBitField.Flags.MessageContent,
  ],
});

const embed = {
  title: 'IMVM BOT',
  description: 'Open an Ticket For Support, Report Or Help, Use it Below of this message.',
  color: 0x5865F2,
  image: {url: 'https://cdn.discordapp.com/attachments/842748665843810334/1136409821764132964/American-Pekin-duck-760x507.jpg'}
};

const menu = new Discord.ActionRowBuilder().addComponents(
  new Discord.StringSelectMenuBuilder()
       .setPlaceholder('Open an Support Ticket')
       .setMaxValues(1)
       .setMinValues(1)
       .setCustomId('ticket-create')
       .setOptions([{
      label: 'Support',
      emoji: '👋',
      description: 'Open an Suppport Ticket',
      value: 'Soporte'
  }, {
      label: 'Reports',
      emoji: '⚠️',
      description: 'Open an report Ticket',
      value: 'report'
  }])
);

Client.on('ready', async (client) => {
  const ticketPanelChannelId = "1164621212694085712"// id del canal
  client.channels.fetch(ticketPanelChannelId)
  .then(channel => channel.send({embeds: [embed], components: [menu]}))
});


client.on('ready', (c) => {
  console.log(`✅ ${c.user.tag} is online.`);
  welcome(client);
  remind(client);
  study(client);
  client.user.setPresence({
    activities: [{ name: `IMVMBOT`, type: Discord.ActivityType.Watching }],
    status: 'online',
    });
});

/// Evento Interaction Create

Client.on("interactionCreate", async (interaction) => {
    if(interaction.isChatInputCommand()) return;
    
    try {
        const execute = require(`./interactions/${interaction.customId}`);
        execute(interaction);
    }  catch (error) {
        console.log('error')
    }
});

client.on('messageCreate', (message) => {
  if (message.author.bot) {
    return;
  }

  if (message.content === 'imvm') {
    message.reply('stfu');
  }
});

client.login(process.env.TOKEN);