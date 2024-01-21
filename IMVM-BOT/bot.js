require('dotenv').config();
const Discord = require('discord.js');
const OpenAI = require('openai');
const openai = new OpenAI(process.env.OPENAI_API_KEY);
const { Client, GatewayIntentBits, Collection, REST, Routes } = require('discord.js');
const fs = require('node:fs');
const path = require('node:path');

const client = new Client({ intents: 2048 })
client.commands = new Collection()

async function generateImage(prompt) {
  const response = await openai.createImage({
  prompt: prompt,
  n: 1,
  size: "1024x1024",
});
  const image_url = response.data.data[0].url
  return image_url
}
async function generate(prompt, model="gpt-3.5-turbo") {
  const completion = await openai.createChatCompletion({
    model: model,
    messages: [{role: "user", content: prompt}],
    max_tokens: 2500
  });
  const text = completion.data.choices[0].message.content
  console.log(completion.data.choices[0].message.content);

  return text;
}

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
client.on('interactionCreate', async interaction => {
  if (interaction.commandName === 'generate-answer') {
    await interaction.deferReply();
    const res = await generate(interaction.options.getString('prompt'))
    await interaction.editReply({ content: res });
  }
  if (interaction.commandName === 'generate-image') {
    await interaction.deferReply();
    const res = await generateImage(interaction.options.getString('prompt'))
    await interaction.editReply({ content: res });
  }
});

// Registro
client.login(process.env.TOKEN);