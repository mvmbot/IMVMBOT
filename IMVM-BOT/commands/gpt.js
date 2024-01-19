const { SlashCommandBuilder } = require('@discordjs/builders');
const { OpenAI } = require('openai');
const openai = new OpenAI(process.env.OPENAI_API_KEY);

module.exports = {
    data: new SlashCommandBuilder()
        .setName('gpt')
        .setDescription('GPT integrated into Discord')
        .addStringOption(option =>
            option.setName('chat')
                .setDescription('Write a question')
                .setRequired(true)
        ),
    async execute(interaction) {
        await interaction.deferReply();

        const chat = interaction.options.getString('chat');

        const messages = [
            { role: 'system', content: 'You are a helpful chatbot. Respond in 3 sentences or less.' },
            { role: 'user', content: chat },
        ];

        const response = await openai.createChatCompletion({ 
            model: 'gpt-3.5-turbo',
            messages: messages,
        });

        const botResponse = response.choices[0].message.content.trim();

        await interaction.editReply(botResponse);
    },
};
