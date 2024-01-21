const { SlashCommandBuilder, EmbedBuilder } = require ('discord.js');
const axios = require('axios');

module.exports = {
    data: new SlashCommandBuilder()
    .setName('gpt')
    .setDescription('Ask AI a question')
    .addStringOption(option.setName('question').setDescription('The question to ask the AI').setRequired(true)),
    async execute (interaction) {

        await interaction.deferReply({ ephemeral: true});

        const { options } = interaction;
        const question = options.getString('question');

        const input = {
            method: 'GET',
            url: 'https://google-bard1.p.rapidapi.com/v1/gemini/gemini-pro-vision',
            headers: {
              api_key: '<REQUIRED>',
              text: '<REQUIRED>',
              userid: '<REQUIRED>',
              image: '<REQUIRED>',
              'X-RapidAPI-Key': '5e8a3a5b23msh60564ec86885905p109cb1jsn5e09bd0b4504',
              'X-RapidAPI-Host': 'google-bard1.p.rapidapi.com'
            }
          };
          
          try {
              const response = await axios.request(options);
              console.log(response.data);
          } catch (error) {
              console.error(error);
          }
    }
}