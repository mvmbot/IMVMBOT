const Discord = require('discord.js');
const { REST } = require('@discordjs/rest');
const { Routes } = require('discord-api-types/v9');
const { Client, Events, GatewayIntentBits, Collection } = require('discord.js');
const fs = require('fs');
const openai = require('openai');
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

  client.user.setPresence({
    activities: [{ name: `/help • IMVMBOT`, type: Discord.ActivityType.Custom }],
    status: 'online',
  });
});

// Evento InteractionCreate
client.on("interactionCreate", async (interaction) => {
  if (!interaction.isCommand()) return;

  try {
    const command = client.commands.get(interaction.commandName);
    if (!command) return;

    await command.execute(interaction);
  } catch (error) {
    console.error(error);
    await interaction.reply({
      content: "Error initializing the command!",
      ephemeral: true,
    });
  }
});

// ChatGPT
client.on(Events.MessageCreate, async (message) => {
  if (message.author.bot) return;
  if (message.channel.id !== BOT_CHANNEL) return;

  message.channel.sendTyping();

  let messages = Array.from(await message.channel.messages.fetch({
      limit: PAST_MESSAGES,
      before: message.id
  }));
  messages = messages.map(m => m[1]);
  messages.unshift(message);

  let users = [...new Set([...messages.map(m => m.member.displayName), client.user.username])];

  let lastUser = users.pop();

  let prompt = `The following is a conversation between ${users.join(", ")}, and ${lastUser}. \n\n`;

  for (let i = messages.length - 1; i >= 0; i--) {
      const m = messages[i];
      prompt += `${m.member.displayName}: ${m.content}\n`;
  }
  prompt += `${client.user.username}:`;
  console.log("prompt:", prompt);

  try {
      const response = await openai.Completion.create({
          prompt,
          model: "text-davinci-003",
          max_tokens: 500,
          stop: ["\n"]
      });

      console.log("response", response); // Imprime toda la respuesta para inspeccionarla

      if (response && response.choices && response.choices[0] && response.choices[0].text) {
          console.log("response text", response.choices[0].text);
          await message.channel.send(response.choices[0].text);
      } else {
          console.error("Invalid response structure:", response);
          await message.channel.send("Error processing response from OpenAI.");
      }
  } catch (error) {
      console.error("Error calling OpenAI API:", error);
      await message.channel.send("Error calling OpenAI API.");
  }
});

// Registro
client.login(process.env.TOKEN);
