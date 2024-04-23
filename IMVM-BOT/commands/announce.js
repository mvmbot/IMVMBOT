const { SlashCommandBuilder } = require("discord.js")
const Discord = require("discord.js")

module.exports = {
    data: new SlashCommandBuilder()
    .setName('announce')
    .setDescription("Usa el sistema de anuncios"),
    cooldown: 3000,
      
    async execute(interaction, Client) {

        let canal = Client.channels.cache.get('1163886058258305066')

    if (!interaction.member.permissions.has(Discord.PermissionFlagsBits.Administrator)) return interaction.reply({content: `❌ **¡Tienes que ser administrador para mandar anuncios!**`}).then(() => {
            setTimeout(() => {
                interaction.deleteReply()
            }, 11000)
        })

            let modal = new Discord.ModalBuilder()
            .setCustomId('modal')
            .setTitle('Anuncio');
      
            let desc = new Discord.TextInputBuilder()
            .setCustomId('description')
            .setLabel("Descripción del mensaje")
            .setStyle(Discord.TextInputStyle.Paragraph)
            .setPlaceholder('Introduzca la descripción del anuncio.')

            const descripcion = new Discord.ActionRowBuilder().addComponents(desc);

            modal.addComponents(descripcion);
          
            await interaction.showModal(modal);

            const modalInteraction = await interaction.awaitModalSubmit({ filter: i => i.user.id === interaction.user.id, time: 1200000_000 })

            const descs = modalInteraction.fields.getTextInputValue('descripcion')
            
            let embed = new Discord.EmbedBuilder()
                .setColor('Random') 
                .setTitle(`📢 | ANUNCIO | IMVMBOT`)
                .setFooter({ text: `IMVMBOT Project©` })
                .setTimestamp()
                .setDescription(`${descs}`)
                .addFields([
                    { name: `Anuncio por:`, value: `${interaction.member}`, inline: true },
                ]);

                canal.send({ content: `||@everyone||`, embeds: [embed] }).then((msg) => {
                    msg.react(`✅`);
                    msg.react(`❌`);
                  });

                await modalInteraction.deferUpdate()
    }
}
