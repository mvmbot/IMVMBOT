// rules.js
const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('rules')
        .setDescription('Muestra las reglas del servidor'),
    async execute(interaction) {
        const rulesText =  'Normativa del Servidor de Soporte del Bot IMVM{"\n"}{"\n"}1.1. Todos los miembros del servidor deben tratar a los demás con respeto y cortesía en todo momento. El lenguaje ofensivo, las burlas y el acoso no serán tolerados.{"\n"}1.2. No se permiten discusiones políticas, religiosas o temas controvertidos en el servidor. Mantén las conversaciones relacionadas con el bot y sus funciones.{"\n"}{"\n"}2. Uso del Canal de Soporte{"\n"}2.1. Utiliza el canal de soporte designado para hacer preguntas o solicitar asistencia con el bot. Evita el uso de canales no relacionados para discutir problemas técnicos.{"\n"}2.2. Proporciona información clara y detallada sobre tu problema o pregunta. Cuanta más información proporciones, más fácil será para los miembros del servidor ayudarte.{"\n"}2.3. Evita hacer spam o inundar el canal de soporte con preguntas repetitivas, comprueba el FAQ. Sé paciente y espera a que un miembro del equipo te responda.{"\n"}{"\n"}3. Compartir Contenido{"\n"}3.1. No compartas contenido inapropiado, ofensivo, o que viole las políticas de Discord en el servidor. Esto incluye imágenes, enlaces y comentarios.{"\n"}3.2. No compartas información personal o sensible en el servidor.{"\n"}{"\n"}4. Resolución de Problemas{"\n"}4.1. Si eres un miembro experimentado de la comunidad, intenta ayudar a otros siempre que puedas, pero asegúrate de dar información precisa y útil.{"\n"}4.2. El equipo de soporte del bot se encargará de resolver problemas técnicos y proporcionar asistencia oficial. No hagas afirmaciones falsas o te hagas pasar por un miembro del equipo de soporte.\n{"\n"}5. Sanciones{"\n"}{"\n"}5.1. Las violaciones de esta normativa pueden resultar en advertencias, expulsiones temporales o permanentes del servidor, dependiendo de la gravedad de la infracción y la cantidad de advertencias previas.{"\n"}5.2. El equipo de moderación se reserva el derecho de tomar decisiones finales en casos de disputa o infracción de la normativa.{"\n"}{"\n"}¡¡Al unirte a este servidor, aceptas cumplir con esta normativa y las políticas de Discord. Si tienes alguna pregunta o preocupación, no dudes en contactar al equipo de moderación o soporte del bot!!'
;
        const rulesEmbed = new MessageEmbed()
            .setColor('#0099ff')
            .setTitle('Reglas del Servidor')
            .setDescription(rulesText);

        await interaction.reply({ embeds: [rulesEmbed] });
    },
};