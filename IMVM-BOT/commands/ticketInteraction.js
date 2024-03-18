const { ModalBuilder, TextInputBuilder, ActionRowBuilder, TextInputStyle, ChannelType, EmbedBuilder, ButtonBuilder, ButtonStyle, PermissionsBitField, TextChannel } = require("discord.js");
const ticket = require('../Schemas/ticketShema');
const { createTranscript } = require('discord-html-transcripts');

module.exports = {
    name: 'interactionCreate',
    async execute (interaction, client)  {

        if (interaction.customId == 'ticketCreateSelect') {
            const modal = new ModalBuilder()
            .setTitle('Crea tu ticket')
            .setCustomId('ticketModal')

            const why = new TextInputBuilder()
            .setCustomId('whyTicket')
            .setRequired(true)
            .setPlaceholder('¿Cuál es la razón de crear el ticket?')
            .setLabel('¿Porque estás creando este ticket?')
            .setStyle(TextInputStyle.Paragraph);

            const info = new TextInputBuilder()
            .setCustomId('infoTicket')
            .setRequired(false)
            .setPlaceholder('Información adicional del ticket')
            .setStyle(TextInputStyle.Paragraph);

            const one = new ActionRowBuilder().addComponents(why);
            const two = new ActionRowBuilder().addComponents(info);

            modal.addComponents(one, two);
            await interaction.showModal(modal);
        } else if (interaction.customId == 'ticketModal') {
            const user = interaction.user;
            const data = await ticket.findOne({ Guild: interaction.guild.id});
            if (!data) return await interaction.reply({ content: `Parece que has encontrado este mensaje pero el sistema de tickets no esta iniciado aquí.`, ephemeral: true});
            else {
                const why = interaction.fields.getTextInputValue('whyTicket');
                const info = interaction.fields.getTextInputValue('infoTicket');
                const category = await interaction.guild.channels.cache.get(data.Category);

                const channel = await interaction.guild.channels.create({
                    name: `ticket-${user.id}`,
                    type: ChannelType.GuildText,
                    topic: `Ticket User: ${user.username}; Ticket Reason: $(why)`,
                    parent: category,
                    permissionOverwrites: [
                        {
                            id: interaction.guild.id,
                            deny: [PermissionsBitField.Flags.ViewChannel]
                        },
                        {
                            id: interaction.user.id,
                            allow: [PermissionsBitField.Flags.ViewChannel, PermissionsBitField.Flags.SendMessages, PermissionsBitField.Flags.ReadMessageHistory]
                        }
                    ]
                });

                const embed = new EmbedBuilder()
                .setColor("Blurple")
                .setTitle(`Ticket from ${user.username} 🎫`)
                .setDescription(`Opening Reason: ${why}\n\nExtra Information: ${info}`)
                .setTimestamp();

                const button = new ActionRowBuilder()
                .addComponents(
                    new ButtonBuilder()
                    .setCustomId('closeTicket')
                    .setLabel(`🔐 Close Ticket`)
                    .setStyle(ButtonStyle.Danger),

                    new ButtonBuilder()
                    .setCustomId('ticketTranscript')
                    .setLabel('📜 Transcript')
                    .setStyle(ButtonStyle.Primary)
                );

                await channel.send({ embeds: [embed], components: [button] });
                await interaction.reply({ content: `Tu ticket ha sido abierto en ${channel}`, ephemeral: true });
            }
        } else if (interaction.customId == 'closeTicket') {
            const closeModal = new ModalBuilder()
            .setTitle('Ticket Closing')
            .setCustomId('closeTicketModal')

            const reason = new TextInputBuilder()
            .setCustomId('closeReasonTicket')
            .setRequired(true)
            .setPlaceholder('¿Cuál es la razón para cerrar este ticket?')
            .setLabel('Provide a closing reason')
            .setStyle(TextInputStyle.Paragraph);

            const one = new ActionRowBuilder().addComponents(reason);

            closeModal.addComponents(one);
            await interaction.showModal(closeModal);
            { else if (interaction.customId == 'closeTicketModal') {
                var channel = interaction.channel;
                var name = channel.name;
                name = name.replace('ticket-', '');
                const member = await interaction.guild.members.cache.ger(name);

                const reason = interaction.fields.getTextInputValue('closeReasonTicket');
                await interaction.reply({ content: `🔐 Closing this ticket...`});

                setTimeout(async () => {
                    await channel.delete().catch(err => {});
                    await member.send(`📢 Estas recibiendo una notificación porque tu ticket en ${interaction.guild.name} ha sido cerrado por: \`${reason}\``).catch(err =>{});
                }, 5000);
            } else if (interaction.customId == 'ticketTranscript') {
                const file = await createTranscript(interaction.channel, {
                    limit: -1,
                    returnBuffer: false
                }
            }

            }
        }
    },
};