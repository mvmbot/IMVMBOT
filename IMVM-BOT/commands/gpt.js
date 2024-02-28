require('dotenv').config();
const { SlashCommandBuilder, MessageEmbed } = require('discord.js');
const openai = require('openai');

openai.apiKey = process.env.OPENAI_API_KEY;

module.exports = {
    data: new SlashCommandBuilder()
        .setName('gpt')
        .setDescription('Ask GPT prompt')
        .addStringOption(option => option.setName('question').setDescription('This is going to be the prompt for GPT').setRequired(true))
        .setDefaultPermission(false),
    async execute(interaction) {
        await interaction.deferReply();

        const question = interaction.options.getString('question');

        try {
            const res = await openai.Completion.create({
                model: 'text-davinci-003',
                max_tokens: 2048,
                temperature: 0.5,
                prompt: question
            });

            if (res.choices && res.choices.length > 0) {
                const embed = new MessageEmbed()
                    .setColor('Purple')
                    .setDescription(`\`\`\`${res.choices[0].text.content}\`\`\``);

                await interaction.editReply({ embeds: [embed] });
            } else {
                await interaction.editReply({ content: 'GPT-3 did not return a response.', ephemeral: true });
            }
        } catch (e) {
            return await interaction.editReply({ content: `Request failed with status code **${e.response.status}**`, ephemeral: true });
        }
    }
};
