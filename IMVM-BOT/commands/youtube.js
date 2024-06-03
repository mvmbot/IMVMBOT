/*
 * File: youtube
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Shows the first video using the YouTube API
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

            interaction.reply({ content: `This is the first result for your search: \n"${searchTerm}":\n${videoURL}`});
        } catch (error) {
            console.error('Error searching on YouTube:', error);
            interaction.reply({ content: 'There was an error searching on YouTube.', ephemeral: true });
        }
    },
};
