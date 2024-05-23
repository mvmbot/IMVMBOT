/*
 * File: faq
 * Author: Álvaro Fernández
 * Github 1.1: https://github.com/afernandezmvm (School acc)
 * Github 1.2: https://github.com/JisuKlk (Personal acc)
 * Desc: This command prints an embed with the FAQ
 */

const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder } = require('discord.js');

const faqText = `
Welcome to the Iesmvmbot FAQ. This document has been created to provide answers to the most common questions our users typically ask. Our mission is to ensure that you have a satisfying and trouble-free experience when using our services.

We have organized the frequently asked questions into thematic categories so that you can quickly find the information you need. We are committed to keeping this document up to date and adding new questions and answers as they arise.

If you can't find the answer you're looking for or have specific needs that are not addressed in this FAQ, please don't hesitate to contact our support team.

__**Question 1:**__ What is a Discord bot?

__**Answer:**__ A Discord bot is a third-party application used to automate tasks, manage servers, and provide additional features on Discord servers. These bots can be programmed to perform a variety of actions, such as moderating chat, playing music, providing information, among other things.

__**Question 2:**__ Why would I want to create a Discord bot?

__**Answer:**__ Discord bots are useful for simplifying server management, enhancing user experiences, and adding custom features to your community. They can assist with moderation, provide helpful information, and entertain server members.

__**Question 3:**__ What is needed to create a Discord bot?

__**Answer:**__ To create a Discord bot, you need basic programming knowledge in languages like JavaScript or Python, a Discord account, and an application in the Discord Developer Portal to obtain an authentication token.

__**Question 4:**__ What programming language should I use to develop a Discord bot?

__**Answer:**__ The most common programming languages for developing Discord bots are JavaScript and Python. Discord offers official libraries and APIs for both options, so you can choose the one you are more comfortable with.

__**Question 5:**__ Is it necessary to have your own server to host the bot?

__**Answer:**__ No, it's not necessary to have your own server. You can host your bot on a local machine, on a cloud service like Heroku, or on a Discord bot hosting service like DisBot or BotGhost.

__**Question 6:**__ Is it legal to create and use Discord bots?

__**Answer:**__ Yes, it is legal to create and use Discord bots as long as you adhere to Discord's Terms of Service. You should not use a bot for malicious activities or activities that violate Discord's policies.

__**Question 7:**__ How can I add my bot to a Discord server?

__**Answer:**__ To add your bot to a server, you need to generate an invitation link through the Discord Developer Portal and then authorize the bot on your server with the appropriate permissions.

__**Question 8:**__ What kind of permissions does my bot need on a server?

__**Answer:**__ The permissions your bot needs depend on the tasks it needs to perform. For example, a music bot needs permissions to play music, and a moderation bot needs permissions to manage messages and users.

__**Question 9:**__ How can I update and maintain my bot?

__**Answer:**__ You should stay informed about updates to the library or API you are using and make necessary changes to your bot. Additionally, it's essential to ensure that the bot is online and functioning correctly at all times.

__**Question 10:**__ Where can I get help if I have issues or questions about creating a Discord bot?

__**Answer:**__ You can seek help in the Discord developer community on servers like "Discord API" or "Discord Bots." You can also refer to Discord's official documentation and search for online tutorials.
`;

module.exports = {
    data: new SlashCommandBuilder()
        .setName('faq')
        .setDescription('Muestra las reglas FAQ del servidor'),
    async execute(interaction) {
        // Creamos un EmbedBuilder
        const faqEmbed = new EmbedBuilder()
            .setColor([176, 92, 255])
            .setTitle('FAQ')
            .setDescription(faqText)
            .setAuthor({
                iconURL: interaction.user.displayAvatarURL(),
                name: interaction.user.tag
            })
            .setImage('https://media.tenor.com/6DUyjTKrrwAAAAAC/bh187-spongebob.gif')
            .setTimestamp()
            .setURL('https://imvmbot.com/')
            .setFooter({
                text: 'By IMVM students', iconURL: 'https://cdn.discordapp.com/attachments/1152263348461781002/1161360242848829520/imvmbot-logo.png?ex=65789d82&is=65662882&hm=f656dbb05cf38c5b2c505d8eafa1408d18c6530cc88528b0870fc35a02441880&'
            });
        await interaction.reply({ embeds: [faqEmbed] });
    },
};
