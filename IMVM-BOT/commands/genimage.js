require('dotenv').config()

const OpenAI = require('openai');
const { SlashCommandBuilder } = require('discord.js');
const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
	data: new SlashCommandBuilder()
   .setName('gen-image')
   .setDescription('Generate a ChatGPT image!')
   .addStringOption(option =>
     option
     .setName('prompt')
     .setDescription('The image prompt to generate')
     .setRequired(true)
    ),
};
