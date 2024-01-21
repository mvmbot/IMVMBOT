require('dotenv').config()

const OpenAI = require('openai');
const { SlashCommandBuilder } = require('discord.js');
const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
	data: new SlashCommandBuilder()
   .setName('gpt')
   .setDescription('Generate a ChatGPT response!')
   .addStringOption(option =>
     option
     .setName('prompt')
     .setDescription('The prompt to generate')
     .setRequired(true)
    ),
};