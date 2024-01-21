const { SlashCommandBuilder } = require('@discordjs/builders');
const OpenAI = require('openai');
const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
	data: new SlashCommandBuilder()
		.setName('gpt')
		.setDescription('Generate a ChatGPT response!')
		.addStringOption(option => option.setName('prompt').setDescription('The prompt to generate').setRequired(true)),
	async execute(interaction) {
		const prompt = interaction.options.getString('prompt');
		const gptResponse = await openai.complete({ engine: 'text-davinci-002', prompt: prompt, maxTokens: 60 });
		await interaction.reply(gptResponse.data.choices[0].text);
	},
};
