const { SlashCommandBuilder } = require('@discordjs/builders');
const { Client, Intents } = require('discord.js');

const client = new Client({ intents: [Intents.FLAGS.GUILDS] });

const classroomCommand = new SlashCommandBuilder()
    .setName('classroom')
    .setDescription('Comando para interactuar con Google Classroom')
    .addSubcommand(subcommand =>
        subcommand
            .setName('join_class')
            .setDescription('Unirse a una clase')
            .addStringOption(option => 
                option.setName('class_code')
                    .setDescription('Código de la clase')
                    .setRequired(true)
            )
    )
    .addSubcommand(subcommand =>
        subcommand
            .setName('exit_class')
            .setDescription('Salir de una clase')
            .addStringOption(option => 
                option.setName('class_code')
                    .setDescription('Código de la clase')
                    .setRequired(true)
            )
    )
    .addSubcommand(subcommand =>
        subcommand
            .setName('view_tasks')
            .setDescription('Ver tareas')
            .addStringOption(option => 
                option.setName('class_code')
                    .setDescription('Código de la clase')
                    .setRequired(true)
            )
    )
    .addSubcommand(subcommand =>
        subcommand
            .setName('view_class')
            .setDescription('Ver información de una clase')
            .addStringOption(option => 
                option.setName('class_code')
                    .setDescription('Código de la clase')
                    .setRequired(true)
            )
    );

client.once('ready', () => {
    console.log(`Logged in as ${client.user.tag}`);
});

client.on('interactionCreate', async interaction => {
    if (!interaction.isCommand()) return;

    const { commandName, options } = interaction;

    if (commandName === 'classroom') {
        const subCommand = options.getSubcommand();

        switch (subCommand) {
            case 'join_class':
                await handleJoinClass(interaction);
                break;
            case 'exit_class':
                await handleExitClass(interaction);
                break;
            case 'view_tasks':
                await handleViewTasks(interaction);
                break;
            case 'view_class':
                await handleViewClass(interaction);
                break;
            default:
                await interaction.reply('¡Subcomando no reconocido!');
                break;
        }
    }
});

async function handleJoinClass(interaction) {
    const classCode = interaction.options.getString('class_code');
    // Lógica para unirse a una clase
    await interaction.reply(`Te has unido a la clase con código ${classCode}.`);
}

async function handleExitClass(interaction) {
    const classCode = interaction.options.getString('class_code');
    // Lógica para salir de una clase
    await interaction.reply(`Has salido de la clase con código ${classCode}.`);
}

async function handleViewTasks(interaction) {
    const classCode = interaction.options.getString('class_code');
    // Lógica para ver tareas
    await interaction.reply(`Mostrando tareas de la clase con código ${classCode}.`);
}

async function handleViewClass(interaction) {
    const classCode = interaction.options.getString('class_code');
    // Lógica para ver información de una clase
    await interaction.reply(`Mostrando información de la clase con código ${classCode}.`);
}

client.login('YOUR_DISCORD_BOT_TOKEN');
