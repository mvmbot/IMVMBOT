const { SlashCommandBuilder } = require('discord.js');
const openai = require('openai');

openai.apiKey = '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';

module.exports = {
    data: new SlashCommandBuilder()
        .setName('chatgpt')
        .setDescription('Ask GPT prompt')
        .addStringOption(option => option.setName('question').setDescription('This is going to be the prompt for GPT').setRequired(true))
        .setDMPermission(false),
    async execute(interaction) {
        await interaction.deferReply();

        const question = interaction.options.getString('question');

        const embed = new EmbedBuilder()
            .setColor('Purple')
            .setDescription(`\`\`\`${res.data.choices[0].text}\`\`\``)

        try {
            const res = await openai.Completion.create({
                model: 'text-davinci-003',
                max_tokens: 2048,
                temperature: 0.5,
                prompt: question
            })

            embed.setDescription(`\`\`\`${res.choices[0].text}\`\`\``);
            await interaction.editReply({ embeds: [embed] });
        } catch (e) {
            return await interaction.editReply({ content: `Request failed with status code **${e.response.status}**`, ephemeral: true })
        }
    }
}