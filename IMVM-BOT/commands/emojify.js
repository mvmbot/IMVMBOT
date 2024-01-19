const { SlashCommandBuilder } = require('@discordjs/builders');

module.exports = {
  data: new SlashCommandBuilder()
    .setName('emojify')
    .setDescription('Convierte texto en emojis')
    .addStringOption(option =>
      option.setName('mensaje')
        .setDescription('Mensaje para convertir en emojis')
        .setRequired(true)), 

  async execute(interaction) {
    await interaction.deferReply();
    const args = interaction.options.getString('mensaje');

    if (!args) {
      interaction.reply('Debes proporcionar un mensaje para transformar en emojis.');
      return;
    }

    const emojiText = emojify(args);
    interaction.followUp(emojiText);
  },
};

function emojify(text) {
  const characters = [...text];
  const emojiCharacters = characters.map((char) => {
    if (/^\s+$/.test(char)) {
      // Mantener los espacios en blanco sin cambios
      return '   ';
    } else {
      // Convertir cada letra en un emoji cuadrado de esa letra
      return `:regional_indicator_${char.toLowerCase()}:`;
    }
  });

  return emojiCharacters.join(' ');
}