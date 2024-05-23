/*
 * File: gtranslate
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const {SlashCommandBuilder, EmbedBuilder } = require('discord.js');
const translate = require('@iamtraction/google-translate');

module.exports = {
    data: new SlashCommandBuilder()
    .setName('gtranslate')
    .setDescription('Traducir usando la API de Google Translate')
    .addStringOption(option => option.setName('message').setDescription('Word or sentence to translate').setRequired(true))
    .addStringOption(option => option.setName('language').setDescription('Language you want to translate to').addChoices(
        {name: 'Spanish or vanish', value: 'es'},
        { name: 'Afrikaans', value: 'af'},
        { name: 'Arabic', value: 'ar'},
        { name: 'German', value: 'de'},
        { name: 'English', value: 'en'},
        { name: 'Spanish', value: 'es'},
        { name: 'Estonian', value: 'et'},
        { name: 'Faroese', value: 'fo'},
        { name: 'French', value: 'fr'},
        { name: 'Croatian', value: 'hr'},
        { name: 'Italian', value: 'it'},
        { name: 'Japanese', value: 'ja'},
        { name: 'Korean', value: 'ko'},
        { name: 'Norwegian', value: 'no'},
        { name: 'Russian', value: 'ru'},
        { name: 'Portuguese', value: 'pt'},

    ).setRequired(true)),

    async execute (interaction) {
        const { options } = interaction;
        const text = options.getString('message');
        const lan = options.getString('language');

        await interaction.reply({ content: `🔨 Translating your messsage`, ephermal: true});

        const applied = await translate(text, { to: `${lan}`});

        const embed = new EmbedBuilder()
        .setColor('Green')
        .setTitle('🔎 Translated Successful')
        .addFields({ name: `Text`, value: `\`\`\`${text}\`\`\``, incline: false})
        .addFields({ name: `Translated Text:`, value: `\`\`\`${applied.text}\`\`\``, incline: false})

        await interaction.editReply({ content: `Text Translated to **${lan}**`, embeds: [embed], ephermal: true})
    }

}