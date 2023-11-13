require('dotenv').config();
const { Client, GatewayIntentBits, EmbedBuilder, PermissionsBitField, Permissions } = require('discord.js');

const client = new Client({intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildMessages, GatewayIntentBits.MessageContent]});

client.once('ready', async () => {
  console.log(`✅ ${client.user.tag} is online.`);
  client.user.setPresence({
    activities: [{ name: `IMVMBOT`, type: 'WATCHING' }],
    status: 'online',
  })

client.login(process.env.TOKEN);  