/*
 * File: calculator
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Command to show a calculator using buttons and mathjs
 */

const { SlashCommandBuilder, EmbedBuilder, ActionRowBuilder, ButtonBuilder, ButtonStyle } = require("discord.js");
const math = require('mathjs');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('calculator')
        .setDescription('Discord Calculator'),
    async execute(interaction) {
        const idPrefix = 'calulator'
        const embed = new EmbedBuilder()
            .setDescription("```\nResults are displayed here\n```")
            .setColor('Blurple')
        const row = new ActionRowBuilder()
            .addComponents(
                new ButtonBuilder()
                    .setLabel('Clear')
                    .setCustomId(idPrefix + "_clear")
                    .setStyle(ButtonStyle.Danger),
                new ButtonBuilder()
                    .setLabel('(')
                    .setCustomId(idPrefix + "_(")
                    .setStyle(ButtonStyle.Primary),
                new ButtonBuilder()
                    .setLabel(')')
                    .setCustomId(idPrefix + "_)")
                    .setStyle(ButtonStyle.Primary),
                new ButtonBuilder()
                    .setLabel('<=')
                    .setCustomId(idPrefix + "_backspace")
                    .setStyle(ButtonStyle.Primary)
            )
        const row1 = new ActionRowBuilder()
            .addComponents(
                new ButtonBuilder()
                    .setLabel('1')
                    .setCustomId(idPrefix + "_1")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('2')
                    .setCustomId(idPrefix + "_2")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('3')
                    .setCustomId(idPrefix + "_3")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('/')
                    .setCustomId(idPrefix + "_/")
                    .setStyle(ButtonStyle.Primary)
            )
        const row2 = new ActionRowBuilder()
            .addComponents(
                new ButtonBuilder()
                    .setLabel('4')
                    .setCustomId(idPrefix + "_4")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('5')
                    .setCustomId(idPrefix + "_5")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('6')
                    .setCustomId(idPrefix + "_6")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('*')
                    .setCustomId(idPrefix + "_*")
                    .setStyle(ButtonStyle.Primary)
            )
        const row3 = new ActionRowBuilder()
            .addComponents(
                new ButtonBuilder()
                    .setLabel('7')
                    .setCustomId(idPrefix + "_7")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('8')
                    .setCustomId(idPrefix + "_8")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('9')
                    .setCustomId(idPrefix + "_9")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('-')
                    .setCustomId(idPrefix + "_-")
                    .setStyle(ButtonStyle.Primary)
            )
        const row4 = new ActionRowBuilder()
            .addComponents(
                new ButtonBuilder()
                    .setLabel('0')
                    .setCustomId(idPrefix + "_0")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('.')
                    .setCustomId(idPrefix + "_.")
                    .setStyle(ButtonStyle.Secondary),
                new ButtonBuilder()
                    .setLabel('=')
                    .setCustomId(idPrefix + "_=")
                    .setStyle(ButtonStyle.Success),
                new ButtonBuilder()
                    .setLabel('+')
                    .setCustomId(idPrefix + "_+")
                    .setStyle(ButtonStyle.Primary)
            )

        const msg = await interaction.reply({ embeds: [embed], components: [row, row1, row2, row3, row4], ephemeral: false });

        let data = "";
        const col = msg.createMessageComponentCollector({
            filter: i => i.user.id === interaction.user.id,
            time: 600000
        });

        col.on('collect', async (i) => {
            const id = i.customId
            const value = id.split('_')[1];
            let extra = "";

            if (value === "=") {
                try {
                    data = math.evaluate(data).toString();
                } catch (e) {
                    data = "";
                    extra = "There is an error. Please press AC to restart";
                }
            } else if (value === "clear") {
                data = "";
                extra = "Results are displayed here"
            } else if (value === "backspace") {
                //data = data.slice(0, data.length - 2);
                data = data.slice(0, -1);
            } else {
                const lc = data[data.length - 1];

                data += `${(
                    (parseInt(value) == value || value === ".")
                    &&
                    (lc == parseInt(lc) || lc === ".")
                ) || data.length === 0 ? "" : " "}` + value;
            }


            i.update({ embeds: [new EmbedBuilder().setColor('Blurple').setDescription(`\`\`\`\n${data || extra}\n\`\`\``)], components: [row, row1, row2, row3, row4], ephemeral: false })
        })
    }
}