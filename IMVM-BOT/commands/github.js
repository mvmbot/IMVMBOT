const { SlashCommandBuilder } = require('@discordjs/builders');
const axios = require('axios');
const { EmbedBuilder } = require('discord.js'); // Corrected import for the embed builder

module.exports = {
  data: new SlashCommandBuilder()
    .setName('github')
    .setDescription('Busca repositorios en GitHub')
    .addStringOption(option =>
      option.setName('search_term')
        .setDescription('Término de búsqueda')
        .setRequired(true)),
  async execute(interaction) {
    const searchTerm = interaction.options.getString('search_term');
    if (!searchTerm) {
      return interaction.reply({ content: 'Por favor proporciona un término de búsqueda.', ephemeral: true });
    }

    try {
      // Add a custom User-Agent header to avoid being blocked by GitHub
      const response = await axios.get(`https://api.github.com/search/repositories?q=${encodeURIComponent(searchTerm)}&per_page=5`, {
        headers: {
          'User-Agent': 'mvmbot',
          'Accept': 'application/vnd.github.v3+json' // Use the latest version of the GitHub API
        }
      });

      // Log the full response data for debugging purposes
      console.log("GitHub API response:", response.data);

      // Check if results were found
      if (response.data.items.length === 0) {
        return interaction.reply({ content: 'No se encontraron repositorios para el término de búsqueda proporcionado.', ephemeral: true });
      }

      // Construct the embed with the search results
      const embed = new EmbedBuilder()
        .setColor('#2b2d31')
        .setTitle(`Resultados de búsqueda en GitHub para "${searchTerm}"`)
        .setDescription('Aquí están los primeros 5 resultados:')
        .setFooter({ text: 'IMVMBOT Search', iconURL: 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/c2/GitHub_Invertocat_Logo.svg/200px-GitHub_Invertocat_Logo.svg.png' });

      response.data.items.forEach((item, index) => {
        embed.addFields({ 
          name: `Resultado ${index + 1}`, 
          value: `[${item.full_name}](${item.html_url}) - ${item.description || 'No description provided'}` 
        });
      });

      await interaction.reply({ embeds: [embed] });
    } catch (error) {
      console.error("Error al buscar en GitHub:", error);

      if (error.response) {
        console.error("Detalles del error de respuesta:", error.response.data);
      } else if (error.request) {
        console.error("No se recibió respuesta del servidor de GitHub:", error.request);
      } else {
        console.error("Error durante la configuración de la solicitud:", error.message);
      }

      await interaction.reply({ content: 'Hubo un error al buscar en GitHub. Por favor, inténtalo de nuevo más tarde.', ephemeral: true });
    }
  },
};
