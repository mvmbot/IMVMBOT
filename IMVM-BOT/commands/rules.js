// rules.js
const { SlashCommandBuilder, MessageEmbed } = require('@discordjs/builders');
const { Client, GatewayIntentBits } = require('discord.js');
const client = new Client({
  intents: [
    GatewayIntentBits.Guilds,
    GatewayIntentBits.GuildMessages,
    GatewayIntentBits.MessageContent,
  ],
});

client.on('interactionCreate', async (interaction) => {
  if (!interaction.isCommand()) return;

  if (interaction.commandName === 'rules') {
    // Crear el embed con las normas del bot
    const rulesEmbed = {
      color: '#0099ff',
      title: 'Normas del Bot',
      description: 'Aquí están las normas del bot:',
      fields: [
        {
          name: 'Norma 1',
          value: 'Texto de la norma 1...',
        },
        {
          name: 'Norma 2',
          value: 'Texto de la norma 2...',
        },
        // Añade más campos según sea necesario
      ],
      timestamp: new Date(),
      footer: {
        text: 'Bot Rules',
      },
    };

    // Responder al comando con el embed
    await interaction.reply({ embeds: [rulesEmbed] });
  }
});
