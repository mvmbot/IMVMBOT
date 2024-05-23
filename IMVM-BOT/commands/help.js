/*
 * File: help
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const { SlashCommandBuilder } = require('@discordjs/builders');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('help')
        .setDescription('Muestra una lista de todos los comandos disponibles'),

    async execute(interaction) {
        const commandList = interaction.client.commands.map(command => `/${command.data.name} - ${command.data.description}`);
        const totalCommands = commandList.length;

        const chunks = [];
        let currentChunk = '';
        let remainingCommands = totalCommands;

        for (const command of commandList) {
            if (currentChunk.length + command.length <= 4096) {
                currentChunk += command + '\n';
                remainingCommands--;
            } else {
                chunks.push(currentChunk);
                currentChunk = command + '\n';
            }
        }

        if (currentChunk.length > 0) {
            chunks.push(currentChunk);
        }
        const randomColor = Math.floor(Math.random() * 16777215);
        const author = interaction.member;
        const embeds = chunks.map((chunk, index) => ({
            color: randomColor,
            title: index === 0 ? 'Comandos disponibles' : '',
            description: chunk,
            author: {
                name: author.user.tag,
                icon_url: author.user.displayAvatarURL()
            },
            footer: {
                text: index === chunks.length - 1 ? `Numero total de comandos: ${totalCommands}` : ''
            }
        }));

        await interaction.reply({ embeds: embeds });
    }
};