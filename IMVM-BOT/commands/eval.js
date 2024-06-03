/*
 * File: eval
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Evaluate JavaScript Code (Only for Developers)
 */

const { SlashCommandBuilder, EmbedBuilder } = require ('discord.js');

module.exports = {
    data: new SlashCommandBuilder()
    .setName('eval')
    .setDescription('Evaluate JS Code (dev only)')
    .addStringOption(option => option.setName('code').setDescription('The code to evaluate').setRequired(true)),
    async execute (interaction) {

        async function sendMessage (message) {
            const embed = new EmbedBuilder()
            .setColor("DarkPurple")
            .setDescription(message);

            await interaction.reply({ embeds: [embed], ephemeral: true });
        }

        if (interaction.member.id !=='255720380864397312') return await sendMessage(`⚠️Only **developers** can use this command!`);

        const { options } = interaction;

        var code = options.getString('code');
        var output;

        try {
            output = await eval (code);
        } catch (error) {
            output = error.toString();
        }

        var replyString =`**Input:**\n\`\`\`js\n${code}\n\`\`\`\n\n**Output:**\n\`\`\`js\n${output}\n\`\`\``;

        if (interaction.replied) {
            const embed = new EmbedBuilder()
            .setColor("DarkPurple")
            .setDescription(replyString);

            await interaction.editReply({ embeds: [embed], ephemeral: true });
        } else {
            await sendMessage(replyString);
        }
    }
}