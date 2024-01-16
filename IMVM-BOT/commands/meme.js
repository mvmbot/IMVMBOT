const { SlashCommandBuilder } = require('@discordjs/builders');
const fetch = require('node-fetch');
const { MessageEmbed, MessageActionRow, MessageButton } = require('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('meme')
        .setDescription('Get a random meme')
        .addStringOption(option =>
            option.setName('category')
                .setDescription('Meme category')
                .setRequired(false)
        ),
    async execute(interaction) {
        const category = interaction.options.getString('category');
        const subReddits = ["meme", "Memes_Of_The_Dank", "memes", "dankmemes"];
        let subreddit = category ? category : subReddits[Math.floor(Math.random() * subReddits.length)];

        const response = await fetch(`https://www.reddit.com/r/${subreddit}/random/.json`);
        const json = await response.json();

        if (!Array.isArray(json) || json.length === 0) {
            return interaction.reply({ content: `No meme found in ${subreddit}`, ephemeral: true });
        }

        let permalink = json[0].data.children[0].data.permalink;
        let memeUrl = `https://reddit.com${permalink}`;
        let memeImage = json[0].data.children[0].data.url;
        let memeTitle = json[0].data.children[0].data.title;
        let memeUpvotes = json[0].data.children[0].data.ups;
        let memeNumComments = json[0].data.children[0].data.num_comments;

        const embed = new MessageEmbed()
            .setAuthor(memeTitle, memeUrl)
            .setImage(memeImage)
            .setColor('RANDOM')
            .setFooter(`👍 ${memeUpvotes} | 💬 ${memeNumComments}`);

        const row = new MessageActionRow()
            .addComponents(
                new MessageButton()
                    .setCustomId('regenMemeBtn')
                    .setLabel('Generate New Meme')
                    .setStyle('SECONDARY'),
            );

        await interaction.reply({ embeds: [embed], components: [row] });
    },
};
