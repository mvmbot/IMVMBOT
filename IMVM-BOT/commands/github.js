/*
 * File: github
 * Author 1: Álvaro Fernández
 * Github 1.1: https://github.com/afernandezmvm (School acc)
 * Github 1.2: https://github.com/JisuKlk (Personal acc)
 * Author 2: Iván Sáez
 * Github 2: https://github.com/ivanmvm
 * Desc: Command with the ability to search repositorys at github (it shows ours one!)
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const axios = require('axios');
const { EmbedBuilder } = require('discord.js');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('github')
    .setDescription('Busca repositorios en GitHub')
    .addStringOption(option =>
      option.setName('search_term')
        .setDescription('Término de búsqueda')
        .setRequired(true)),
  // We ask the user for a term to search as a repository
  async execute(interaction) {
    const searchTerm = interaction.options.getString('search_term');
    if (!searchTerm) {
      // In case it's empty we tell the user we really need something to search for
      return interaction.reply({ content: 'Please provide a search term.', ephemeral: true });
    }

    try {
      // Add a custom User-Agent header to avoid being blocked by GitHub
      const response = await axios.get(`https://api.github.com/search/repositories?q=${encodeURIComponent(searchTerm)}&per_page=5`, {
        headers: {
          'User-Agent': 'mvmbot',
          'Accept': 'application/vnd.github.v3+json'
        }
      });

      // Log the full response data for debugging purposes
      console.log("GitHub API response:", response.data);

      // Check if results were found
      if (response.data.items.length === 0) {
        return interaction.reply({ content: 'No repositories were found for the search term provided.', ephemeral: true });
      }

      // Construct the embed with the search results
      const embed = new EmbedBuilder()
        .setColor('#2b2d31')
        .setTitle(`GitHub search results for "${searchTerm}"🔎`)
        .setDescription('The first 5 results:')
        .setFooter({ text: 'IMVMBOT Search', iconURL: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/GitHub_Invertocat_Logo.svg/200px-GitHub_Invertocat_Logo.svg.png' });

      // We use a forEach to iterate the results and print some info
      response.data.items.forEach((item, index) => {
        embed.addFields({
          name: `Result ${index + 1}`,
          value: `[${item.full_name}](${item.html_url}) - ${item.description || 'No description provided'}`
        });
      });

      // Finally, we send the embed to the user
      await interaction.reply({ embeds: [embed] });
    } catch (error) {
      // In case somethings wrong, here's lotta logs ^*^
      console.error("Error searching on GitHub:", error);
      if (error.response) {
        console.error("Response error details:", error.response.data);
      } else if (error.request) {
        console.error("No response received from GitHub server:", error.request);
      } else {
        console.error("Error during application setup:", error.message);
      }
      // Since logs are for us, the devs, we gotta print something for the user, so we tell the user there's something wrong
      await interaction.reply({ content: 'There was an error searching GitHub. Please try again later.', ephemeral: true });
    }
  },
};
