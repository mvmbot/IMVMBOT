const { ContextMenuCommandBuilder, EmbedBuilder, ApplicationCommandType } = require('discord.js');
const puppeteer = require('puppeteer');

module.exports = {
    data: new ContextMenuCommandBuilder()
    .setName("IMVMBOT AI")
    .setType(ApplicationCommandType.Message),

    async execute(interaction) {
        await interaction.deferReply({ ephemeral: true });
        var message = await interaction.channel.messages.fetch(interaction.targetId);

        if (message.content.length <= 0) return await interaction.editReply({ content: `⚠️ Debes tener un mensaje coherente para utilizar nuestra IA` });

        async function getResponse() {
            const browser = await puppeteer.launch({ headless: true });
            const page = await browser.newPage();

            await page.goto('https://chat-app-f2d296.zappier.app/');

            const textBoxSelector = 'textarea[aria-label="chatbot-user-prompt"]';
            await page.waitForSelector(textBoxSelector);

            await page.type(textBoxSelector, message.content);
            await page.keyboard.press("Enter");

            await page.waitForSelector('[data-testid="final-bot-response"] p').catch(err => {
                return;
            });

            const value = await page.$$eval('[data-testid="final-bot-response"]', async (elements) => {
                return elements.map((element) => element.textContent);
            });

            await browser.close();

            value.shift();
            return value.join('\n\n\n\n');
        }

        const embed = new EmbedBuilder()
            .setColor("BLURPLE")
            .setDescription(`🤖 **La respuesta a tu mensaje: **\`${message.content}\`**\n\n\`\`\`${await getResponse()}\`\`\``);

        await interaction.editReply({ embeds: [embed] });
    }
};
