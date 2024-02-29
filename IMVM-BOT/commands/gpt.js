const { SlashCommandBuilder } = require('discord.js');
const openai = require("../utils/openAi");

module.exports = {
    data: new SlashCommandBuilder()
        .setName('gpt')
        .setDescription('Ask GPT prompt')
        .addStringOption ((option)=>
            option
                .setName("prompt")
                .setDescription("Write your question")
                .setRequired (true)
            ),
        async execute(interaction) {
        await interaction.deferReply();

        const question = interaction.options.getString("prompt");
        
        const messages = [
        {
            role: "system",
            content:
                "You are a chatbot that gives helpful advice. Give your advice in 3 sentences or less.",
        },
        {
            role: "user",
            content: question,
        },
    ];

    const completion = await openai.createChatCompletion({
        model: "gpt-3.5-turbo",
        messages: messages,
        temperature: 0.7,
    });

    const advice = completion.data.choices[0].message.content;

    await interaction.editReply(advice);
    },
};
