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

client.on('ready', (c) => {
  console.log(`✅ ${c.user.tag} is online.`);
  welcome(client);
  remind(client);
  study(client);
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