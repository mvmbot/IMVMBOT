const Discord = require('discord.js');
const { REST } = require('@discordjs/rest');
const { Routes } = require('discord-api-types/v9');
const { Client, GatewayIntentBits, Collection } = require('discord.js');
const fs = require('fs');
require('dotenv').config();

const client = new Client({ intents: [GatewayIntentBits.Guilds, GatewayIntentBits.GuildMessages, GatewayIntentBits.MessageContent] });
client.commands = new Collection();

// Carga los comandos
const commandFiles = fs.readdirSync('./commands').filter(file => file.endsWith('.js'));
for (const file of commandFiles) {
  const command = require(`./commands/${file}`);
  client.commands.set(command.data.name, command);
}

client.once('ready', async () => {
  console.log(`✅ ${client.user.tag} is online.`);

  // Registra los comandos slash
  const rest = new REST({ version: '9' }).setToken(process.env.TOKEN);
  const commands = client.commands.map(({ data }) => data.toJSON());

  try {
    console.log('Started refreshing application (/) commands.');
    await rest.put(
      Routes.applicationGuildCommands(client.user.id, '1163886056832237718'),
      { body: commands },
    );
    console.log('Successfully reloaded application (/) commands.');
  } catch (error) {
    console.error(error);
  }
  
const channel = client.channels.cache.get('1164621212694085712');

// Crea el embed.
const embedMessage = new Discord.MessageEmbed(embed);

// Crea el menú de selección.
const menu = new Discord.MessageActionRow().addComponents(
  new Discord.MessageSelectMenu()
    .setCustomId('ticket-create')
    .setPlaceholder('Open a Support Ticket')
    .addOptions([
      {
        label: 'Support',
        emoji: '👋',
        description: 'Open an Support Ticket',
        value: 'Soporte'
      },
      {
        label: 'Reports',
        emoji: '⚠️',
        description: 'Open a Report Ticket',
        value: 'Reportes'
      }
    ])
);

// Envía el embed y el menú de selección.
channel.send({ embeds: [embedMessage], components: [menu] });

  client.user.setPresence({
    activities: [{ name: `/help • IMVMBOT`, type: Discord.ActivityType.Custom }],
    status: 'online',
  });
});

/// Evento Interaction Create
client.on("interactionCreate", async (interaction) => {
  if (interaction.isChatInputCommand()) return;

  try {
    const execute = require(`./interactions/${interaction.customId}`);
    execute(interaction);
  } catch (error) {
    console.error(error);
  }
});

// Registro
client.login(process.env.TOKEN);