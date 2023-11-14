// rules.js
const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('rules')
        .setDescription('Muestra las reglas del servidor.'),
    async execute(interaction) {
        const rulesEmbed = new MessageEmbed()
            .setColor('#0099ff')
            .setTitle('Reglas del Servidor')
            .setDescription('Aquí están las reglas del servidor...')
            .addField('1. Respeto', 'Todos los miembros del servidor deben tratar a los demás con respeto y cortesía en todo momento. El lenguaje ofensivo, las burlas y el acoso no serán tolerados.')
            .addField('2. Uso del Canal de Soporte', 'Utiliza el canal de soporte designado para hacer preguntas o solicitar asistencia con el bot. Evita el uso de canales no relacionados para discutir problemas técnicos.')
            .addField('3. Compartir Contenido', 'No compartas contenido inapropiado, ofensivo, o que viole las políticas de Discord en el servidor. Esto incluye imágenes, enlaces y comentarios.')
            .addField('4. Resolución de Problemas', 'Si eres un miembro experimentado de la comunidad, intenta ayudar a otros siempre que puedas, pero asegúrate de dar información precisa y útil.')
            .addField('5. Sanciones', 'Las violaciones de estas normativas pueden resultar en sanciones, que van desde advertencias hasta la expulsión del servidor.');

            interaction.channel.send({ embeds: [embed]});
        await interaction.reply({content: `embed Sent Correctly `});
    },
};