const { SlashCommandBuilder } = require('@discordjs/builders');
const { OpenAI } = require('openai');
const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
    data: new SlashCommandBuilder()
        .setName('gpt')
        .setDescription('Get advice from GPT')
        .addStringOption(option => 
            option.setName('question')
                .setDescription('Enter your question')
                .setRequired(true)
        ),
    async execute(interaction) {
        await interaction.deferReply({ content: 'Processing your request...', ephemeral: true });

        const question = interaction.options.getString('question');

        const messages = [
            {
                role: 'system',
                content: 'You are a chatbot that gives helpful advice. Add advice in three sentences or less.',
            },
            {
                role: 'user',
                content: question,
            },
        ];

        const completion = await openai.createChatCompletion({
            model: 'gpt-3.5-turbo',
            messages,
            temperature: 0.7,
        });

        const advice = completion.data.choices[0].message.content;

        await interaction.editReply(advice);
    },
};
