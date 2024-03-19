const { SlashCommandBuilder } = require('@discordjs/builders');
const { MessageEmbed } = require('discord.js');
const puppeteer = require('puppeteer');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('ai')
        .setDescription('Utiliza la IA de IMVMBOT para obtener una respuesta a tu mensaje.')
        .addSubcommand(subcommand =>
            subcommand.setName('message')
                .setDescription('El mensaje del que deseas obtener respuesta.')
                .setRequired(true)
        ),

    async execute(interaction) {
        await interaction.deferReply({ ephemeral: true });

        let messageContent;

        if (interaction.options.getSubcommand() === 'message') {
            messageContent = interaction.options.getString('message');
        } else {
            const message = await interaction.channel.messages.fetch(interaction.targetId);
            messageContent = message.content;
        }

        if (!messageContent || messageContent.length <= 0) return await interaction.editReply({ content: `⚠️ Debes tener un mensaje coherente para utilizar nuestra IA` });

        async function getResponse(content) {
            const browser = await puppeteer.launch({ headless: true });
            const page = await browser.newPage();

            await page.goto('https://chat-app-f2d296.zappier.app/');

            const textBoxSelector = 'textarea[aria-label="chatbot-user-prompt"]';
            await page.waitForSelector(textBoxSelector);

            await page.type(textBoxSelector, content);
            await page.keyboard.press("Enter");

            await page.waitForSelector('[data-testid="final-bot-response"] p');

            const value = await page.$$eval('[data-testid="final-bot-response"] p', (elements) => {
                return elements.map((element) => element.textContent);
            });

            await browser.close();

            return value.join('\n\n');
        }

        const embed = new MessageEmbed()
            .setColor("BLURPLE")
            .setDescription(`🤖 **La respuesta a tu mensaje: **\`${messageContent}\`\n\n\`\`\`${await getResponse(messageContent)}\`\`\``);

        await interaction.editReply({ embeds: [embed] });
    },
};