/*
 * File: poll
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Create a poll to vote some topic
 */

const { SlashCommandBuilder, ChannelType, EmbedBuilder } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('poll')
        .setDescription('Crea una encuesta en el canal especificado.')
        .addStringOption(option =>
            option.setName('question')
                .setDescription('La pregunta de la encuesta.')
                .setRequired(true)
        )
        .addChannelOption(option =>
            option.setName('channel')
                .setDescription('El canal donde se enviará la encuesta.')
                .setRequired(true)
                .addChannelTypes(ChannelType.GuildText)
        )
        .addStringOption(option =>
            option.setName('options')
                .setDescription('Las opciones de la encuesta, separadas por comas.')
                .setRequired(true)
        ),
    async execute(interaction) {
        const pregunta = interaction.options.getString('question');
        const canal = interaction.options.getChannel('channel');
        const opciones = interaction.options.getString('options').split(',');

        if (opciones.length < 2 || opciones.length > 10) {
            return interaction.reply('The poll must have between 2 and 10 options.');
        }

        const emojis = ['1️⃣', '2️⃣', '3️⃣', '4️⃣', '5️⃣', '6️⃣', '7️⃣', '8️⃣', '9️⃣', '🔟'];

        const embed = new EmbedBuilder()
            .setColor('#00FF00')
            .setTitle(`📊 Poll - Created by ${interaction.user.tag}`)
            .setDescription(pregunta)
            .setTimestamp();

        opciones.forEach((opcion, index) => {
            embed.addFields({ name: `${emojis[index]} ${opcion}`, value: '\u200B', inline: false });
        });

        const mensaje = await canal.send({ embeds: [embed] });

        for (let i = 0; i < opciones.length; i++) {
            await mensaje.react(emojis[i]);
        }

        const reacciones = new Map();
        const recolectorVotos = mensaje.createReactionCollector({
            filter: (reaction, user) => emojis.includes(reaction.emoji.name) && !user.bot
        });

        recolectorVotos.on('collect', (reaction, user) => {
            if (reacciones.has(user.id)) {
                const prevReaction = reacciones.get(user.id);
                mensaje.reactions.cache.get(prevReaction).users.remove(user);
            }
            reacciones.set(user.id, reaction.emoji.name);
        });

        recolectorVotos.on('remove', (reaction, user) => {
            reacciones.delete(user.id);
        });

        await interaction.reply(`Poll created in ${canal}.`);
    },
};