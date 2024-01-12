const { SlashCommandBuilder } = require('@discordjs/builders');
const { CommandInteraction } = require('discord.js');
const OpenAI = require('openai');
require('dotenv').config();

const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
    data: new SlashCommandBuilder()
        .setName('gpt')
        .setDescription('Generates a message using GPT-3.')
        .addStringOption(option =>
            option.setName('prompt')
                .setDescription('The prompt for GPT-3 to respond to.')
                .setRequired(true)),
    /**
     * @param {CommandInteraction} interaction
     */
    async execute(interaction) {
        const prompt = interaction.options.getString('prompt');

        const response = await openai.completions.create({
            engine: 'davinci-codex',
            prompt: prompt,
            maxTokens: 60
        });
        
        await interaction.reply(response.choices[0].text.trim());
    },
};
