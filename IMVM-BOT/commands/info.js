const { SlashCommandBuilder, EmbedBuilder } = require('discord.js');
 
module.exports = {
    data: new SlashCommandBuilder()
        .setName('info')
        .setDescription('Informacion De IMVMBOT'),
    async execute(interaction, client) {
 
    
                const totalMembers = await interaction.client.guilds.cache.reduce((acc, guild) => acc + guild.memberCount, 0);
 
                const embed = new EmbedBuilder()
                  .setColor("DarkBlue")
                  .setDescription(`⚒️ Estadisticas de **${client.user.username} ⚒️**` )
                  .addFields({ name: "** **", value: `** **`, inline: false})
                  .addFields({ name: "🤖 Comandos:", value: `${client.commands.size}`, inline: true})
                  .addFields({ name: "👨‍👩‍👧‍👦 Usuarios:", value: `${totalMembers}`, inline: true})
                  .addFields({ name: "🌎 Servers:", value: `${client.guilds.cache.size}`, inline: true})
                  .addFields({ name: "💬 Canales:", value: `${client.channels.cache.size}`, inline: true})
                  .addFields({ name: "📅 Creado:", value: `<t:${parseInt(client.user.createdTimestamp / 1000,10)}:R>`, inline: true})
                  .addFields({ name: "🏓 Ping", value: `${client.ws.ping}ms`, inline: true})
                  .addFields({ name: "⏰ Tiempo Activo", value: `<t:${parseInt(client.readyTimestamp / 1000,10)}:R>`, inline: true})
                  .addFields({ name: "💳 ID ", value: `${client.user.id}`, inline: true})
                  .addFields({ name: "💾 CPU Usada", value: `${(process.memoryUsage().heapUsed /1024 /1024).toFixed(2)}%`, inline: true})
 
    await interaction.reply({ embeds: [embed], ephemeral: false });
            
    },

    };