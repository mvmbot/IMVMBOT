/*
 * File: youtube
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const axios = require('axios');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('youtube')
        .setDescription('Busca un video en YouTube.')
        .addStringOption(option =>
            option.setName('video')
                .setDescription('El término de video de búsqueda.')
                .setRequired(true)),
    async execute(interaction) {
        const searchTerm = interaction.options.getString('video');

        try {
            const response = await axios.get('https://www.googleapis.com/youtube/v3/search', {
                params: {
                    part: 'snippet',
                    maxResults: 1,
                    q: searchTerm,
                    key: process.env.YOUTUBE_API_KEY,
                },
            });

            const video = response.data.items[0];
            const videoTitle = video.snippet.title;
            const videoURL = `https://www.youtube.com/watch?v=${video.id.videoId}`;

            interaction.reply({ content: `Este es el primer resultado a tu busqueda: \n"${searchTerm}":\n${videoURL}`});
        } catch (error) {
            console.error('Error al buscar en YouTube:', error);
            interaction.reply({ content: 'Hubo un error al buscar en YouTube.', ephemeral: true });
        }
    },
};
