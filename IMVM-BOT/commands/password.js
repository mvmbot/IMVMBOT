/*
 * File: password
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Create a secure password
 */

const { SlashCommandBuilder, IntegerOptionType, EmbedBuilder } = require('discord.js');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('password-generator')
    .setDescription('Genera aleatoriamente, una contraseña segura basada en tus selecciones.')
    .addIntegerOption(option =>
      option.setName('length')
        .setDescription('Length of the random string (10-100)')
        .setMinValue(10)
        .setMaxValue(100)
        .setRequired(true)
    )
    .addBooleanOption(option =>
      option.setName('uppercase')
        .setDescription('Include uppercase letters (A-Z)')
        .setRequired(true)
    )
    .addBooleanOption(option =>
      option.setName('lowercase')
        .setDescription('Include lowercase letters (a-z)')
        .setRequired(true)
    )
    .addBooleanOption(option =>
      option.setName('numbers')
        .setDescription('Include numbers (0-9)')
        .setRequired(true)
    )
    .addBooleanOption(option =>
      option.setName('symbols')
        .setDescription('Include symbols (!@#$%^&*)')
        .setRequired(true)
    )
    .addBooleanOption(option =>
      option.setName('exclude_similar_chars')
        .setDescription('Exclude visually similar characters (l, 1, O, 0, etc.)')
        .setRequired(true)
    )
    .addStringOption(option =>
      option.setName('custom_chars')
        .setDescription('Optional: Ingresa caracteres adicionales a implementar')
        .setRequired(false)
    ),

  async execute(interaction, client) {
    const uppercase = interaction.options.getBoolean('uppercase') || false;
    const lowercase = interaction.options.getBoolean('lowercase') || false;
    const numbers = interaction.options.getBoolean('numbers') || false;
    const symbols = interaction.options.getBoolean('symbols') || false;
    const stringLength = interaction.options.getInteger('length');
    const excludeSimilarChars = interaction.options.getBoolean('exclude_similar_chars') || false;
    const customChars = interaction.options.getString('custom_chars') || '';

    if (!uppercase && !lowercase && !numbers && !symbols) {
      return await interaction.reply({ content: 'Please choose at least one character type.', ephemeral: true });
    }

    let characterSet = '';
    if (uppercase) characterSet += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (lowercase) characterSet += 'abcdefghijklmnopqrstuvwxyz';
    if (numbers) characterSet += '0123456789';
    if (symbols) characterSet += '!"#¤%&/()=?`.';
    if (excludeSimilarChars) {
      characterSet = characterSet.replace(/[IlO01]/g, '');
    }
    if (customChars) characterSet += customChars;

    if (!characterSet) {
      return await interaction.reply({ content: 'Error: Please choose at least one character type.', ephemeral: true });
    }

    let passwordGenerator = '';
    for (let i = 0; i < stringLength; i++) {
      passwordGenerator += characterSet[Math.floor(Math.random() * characterSet.length)];
    }


    const embed = new EmbedBuilder()
    .setColor('DarkBlue')
    .setTitle('Password Generated!')

    .addFields(
      ({ name: 'Generated Password:', value: passwordGenerator, inline: false }),
      ({ name: 'Length:', value: `${stringLength} characters`, inline: true }),
      ({ name: 'Characters Used:', value: `${characterSet.length} types`, inline: true })

    )
    .setTimestamp()

  await interaction.reply({ embeds: [embed], ephemeral: true });
          }
        }