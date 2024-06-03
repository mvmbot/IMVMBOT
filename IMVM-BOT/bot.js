/*
 * File: bot
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: The main file to load IMVMBOT
 */

const Discord = require('discord.js');
const { REST } = require('@discordjs/rest');
const { Routes } = require('discord-api-types/v9');
const { Client, GatewayIntentBits, Collection } = require('discord.js');
const { google } = require('googleapis');
const fs = require('fs');
const { createTranscript } = require('discord-html-transcripts');
const oauth2Client = new google.auth.OAuth2(process.env.GOOGLE_CLIENT_ID, process.env.GOOGLE_CLIENT_SECRET);
require('dotenv').config();

const client = new Client({ intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildMessages, GatewayIntentBits.MessageContent] });
client.commands = new Collection();

// Load commands
const commandFiles = fs.readdirSync('./commands').filter(file => file.endsWith('.js'));
for (const file of commandFiles) {
  const command = require(`./commands/${file}`);
  client.commands.set(command.data.name, command);
}

client.once('ready', async () => {
  console.log(`✅ ${client.user.tag} is online.`);
  
  // Register slash commands
  const rest = new REST({ version: '10' }).setToken(process.env.TOKEN);
  const commands = client.commands.map(({ data }) => data);
  try {
    console.log('Started refreshing application (/) commands.');
    await rest.put(
      Routes.applicationCommands(client.user.id),
      { body: commands },
    );
    console.log('Successfully reloaded application (/) commands.');
  } catch (error) {
    console.error(error);
  }

  // Set ActivityType
  client.user.setPresence({
    activities: [{ name: `/help • IMVMBOT`, type: Discord.ActivityType.Custom }],
    status: 'online',
  });
});

// Event InteractionCreate for commands
client.on("interactionCreate", async (interaction) => {
  if (!interaction.isCommand()) return;
  try {
    const command = client.commands.get(interaction.commandName);
    if (!command) return;
    await command.execute(interaction, oauth2Client);
  } catch (error) {
    console.error(error);
    await interaction.reply({
      content: "Error initializing the command!",
      ephemeral: true,
    });
  }
});

// Event InteractionCreate for other interactions
client.on("interactionCreate", async (interaction) => {
  if (interaction.isChatInputCommand()) return;
  try {
    const execute = require(`./interactions/${interaction.customId}`);
    execute(interaction);
  } catch (error) {
    console.log(error);
  }
});

// Register (TOKEN)
client.login(process.env.TOKEN);