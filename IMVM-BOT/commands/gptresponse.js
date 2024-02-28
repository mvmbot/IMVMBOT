const { ContextMenuInteraction, MessageEmbed, ApplicationCommandType } = require('discord.js');
const puppeteer = require('puppeteer');

module.exports = {
    data: {
        name: "AI Response",
        type: ApplicationCommandType.MESSAGE
    },
    async execute(interaction) {

        await interaction.deferReply({ ephemeral: true });
        const message = await interaction.channel.messages.fetch(interaction.targetId);

        if (message.content.length <= 0) return await interaction.editReply({ content: 'You must have a message prompt to have a response' })

        async function getResponse() {
            const browser = await puppeteer.launch({ headless: true });
            const page = await browser.newPage();

            await page.goto('https://chat-app-f2d296.zapier.app/');

            const textBoxSelector = 'textarea[aria-label="chatbot-user-prompt"]';
            await page.waitForSelector(textBoxSelector);

            await page.type(textBoxSelector, message.content);
            await page.keyboard.press("Enter");

            await page.waitForSelector('[data-testid="final-bot-response"] p').catch(err => {
                return;
            });

            const value = await page.$$eval('[data-testid="final-bot-response"]', elements => {
                return elements.map(element => element.textContent);
            });

            await browser.close();

            value.shift();
            return value.join('\n\n\n\n');
        }

        const embed = new MessageEmbed()
            .setColor("Blurple")
            .setDescription(`**Here's the AI response for the message:** \`${message.content}\`\n\n\`\`\`${await getResponse()}\`\`\``);

        await interaction.editReply({ embeds: [embed] });
    }
}
