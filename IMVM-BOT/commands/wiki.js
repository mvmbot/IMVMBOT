/*
 * File: wiki
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Shows you a summary of the term searched using the Wikipedia API
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const axios = require('axios');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('wiki')
    .setDescription('Muestra el resumen de Wikipedia para un término dado')
    .addStringOption(option =>
      option.setName('término')
        .setDescription('Término para buscar en Wikipedia')
        .setRequired(true)
    ),
  async execute(interaction) {
    const term = interaction.options.getString('término');

    try {
      const response = await axios.get(`https://es.wikipedia.org/api/rest_v1/page/summary/${term}`);
      const { title, extract, thumbnail } = response.data;

      const embed = {
        title: title,
        description: extract,
        thumbnail: { url: thumbnail ? thumbnail.source : '' }
      };

      interaction.reply({ embeds: [embed] });
    } catch (error) {
      console.error(error);
      interaction.reply('An error occurred while retrieving information from Wikipedia.');
    }
  },
};