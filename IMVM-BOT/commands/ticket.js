const { SlashCommandBuilder, Permissions, ActionRowBuilder, StringSelectMenuBuilder, ChannelTypes, MessageEmbed } = require('discord.js');
const ticket = require('ticketSchema');

module.exports = {
    data: new SlashCommandBuilder()
        .setName('ticket')
        .setDescription('Crea un ticket de soporte')
        .addSubcommand(command =>
            command.setName('send')
                .setDescription('Send the ticket message')
                .addStringOption(option =>
                    option.setName('name')
                        .setDescription('The name for the select menu')
                        .setRequired(true))
                .addStringOption(option =>
                    option.setName('message')
                        .setDescription('A message to add to embed')
                        .setRequired(false)))
        .addSubcommand(command =>
            command.setName('setup')
                .setDescription('Setup the ticket category')
                .addChannelOption(option =>
                    option.setName('category')
                        .setDescription('The category to send tickets in')
                        .setRequired(true)
                        .addChannelType(ChannelTypes.GUILD_CATEGORY)))
        .addSubcommand(command =>
            command.setName('remove')
                .setDescription('Disable the ticket category')),
    async execute(interaction) {

        const { options } = interaction;
        const sub = options.getSubcommand();
        const data = await ticket.findOne({ Guild: interaction.guild.id });

        switch (sub) {
            case 'send':
                if (!data) return await interaction.reply({ content: '⚠️ Tienes que ejecutar /ticket antes de enviar el mensaje de ticket...', ephemeral: true });

                const name = options.getString('name');
                var message = options.getString('message') || 'Crea un ticket para hablar con el staff de IMVMBOT';

                const select = new ActionRowBuilder()
                    .addComponents(
                        new StringSelectMenuBuilder()
                            .setCustomId('ticketCreateSelect')
                            .setPlaceholder(`🌍 ${name}`)
                            .setMinValues(1)
                            .addOption({
                                label: 'Create your ticket',
                                description: 'Click para empezar el proceso de creación de ticket.',
                                value: 'createTicket'
                            })
                    );

                const embed = new MessageEmbed()
                    .setColor("BLURPLE")
                    .setTitle('Create a ticket!')
                    .setDescription(message + `🎫`)
                    .setFooter(`${interaction.guild.name}`, `${interaction.guild.iconURL()}`);

                await interaction.reply({ content: `⬇️ Se ha enviado tu mensaje de ticket abajo.`, ephemeral: true });
                await interaction.channel.send({ embeds: [embed], components: [select] });

                break;
            case 'remove':
                if (!data) return await interaction.reply({ content: `⚠️ Todavía no has creado ningún ticket en el sistema.`, ephemeral: true });
                else {
                    await ticket.deleteOne({ Guild: interaction.guild.id });
                    await interaction.reply({ content: `Se ha borrado tu categoria de ticket.`, ephemeral: true });
                }
                break;
            case 'setup':
                if (data) return await interaction.reply({ content: `⚠️ Parece que ya has creado una categoria de ticket a <#${data.Category}>`, ephemeral: true });
                else {
                    const category = options.getChannel('category');
                    await ticket.create({
                        Guild: interaction.guild.id,
                        Category: category.id
                    });
                    await interaction.reply({ content: `He configurado la categoria a **${category}**! Usa /ticket para utilizar un mensaje de creación de ticket`, ephemeral: true });
                }
        }
    }
};