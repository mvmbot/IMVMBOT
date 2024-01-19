const { SlashCommandBuilder, MessageEmbed } = require('discord.js');
const puppeteer = require('puppeteer');

module.exports = {
    data: new SlashCommandBuilder()
    .setName('chatgpt')
    .setDescription('Ask GPT a question')
    .addStringOption(option => option.setName('prompt').setDescription('The prompt AI').setRequired(true)),
    async execute (interaction) {
        
        await interaction.reply({ content: `Loading your response... (This could take some time)`, ephemeral: true });

        const { options } = interaction;
        const prompt = options.getString('prompt');

        const browser = await puppeteer.launch({ headless: true });
        const page = await browser.newPage();

        await page.goto('https://chat-app-f2d296.zapier.app/');

        const textBoxSelector = 'textarea[arial-label="chatbot-user-prompt"]';
        await page.waitForSelector(textBoxSelector);
        await page.type(textBoxSelector, prompt);

        await page.keyboard.press('Enter');
        
        await page.waitForSelector('[data-testid="final-bot-response"] p');

        var value = await page.$$eval('[data-testid="final-bot-response"]', async (elements) => {
            return elements.map((element) => element.textContent);
        });

        setTimeout(async () => {
            if (value.length == 0) return await interaction.editReply ({ content: `There was an error getting that response`})
        }, 30000);

        await browser.close();

        value.shift();
        const embed = new MessageEmbed()
        .setColor("Purple")
        .setDescription(`\`\`\`${value.join(`\n\n\n\n`)}\`\`\``);

        await interaction.editReply({ content: '', embeds: [embed]});
    }
}