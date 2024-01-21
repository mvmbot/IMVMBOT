require('dotenv').config();
const Discord = require('discord.js');
const { Client, GatewayIntentBits, Collection, REST, Routes } = require('discord.js');
const fs = require('fs');
const path = require('path');

const client = new Client({ intents: [Discord.Intents.FLAGS.Guilds, Discord.Intents.FLAGS.GuildMessages] });
client.commands = new Collection();

const commandFiles = fs.readdirSync('./commands').filter(file => file.endsWith('.js'));
for (const file of commandFiles) {
  const command = require(`./commands/${file}`);
  client.commands.set(command.data.name, command);
}

client.once('ready', async () => {
  console.log(`✅ ${client.user.tag} is online.`);
  const commands = client.commands.map(({ data }) => data.toJSON());
  await client.guilds.cache.get('YOUR_GUILD_ID').commands.set(commands);
  client.user.setPresence({
    activities: [{ name: '/help • IMVMBOT', type: 'PLAYING' }],
    status: 'online',
  });
});

client.on('interactionCreate', async interaction => {
  if (!interaction.isCommand()) return;

  const { commandName } = interaction;

  if (!client.commands.has(commandName)) return;

  try {
    await client.commands.get(commandName).execute(interaction);
  } catch (error) {
    console.error(error);
    await interaction.reply({ content: 'There was an error while executing this command!', ephemeral: true });
  }
});

client.login(process.env.TOKEN);
