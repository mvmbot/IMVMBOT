/*
 * File: welcome
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc: Welcome message when user enter to Official Server
 */

const { Client } = require("discord.js");
const client = new Client();

client.on('guildMemberAdd', (member) => {
const { EmbedBuilder } = require('discord.js');

const alda = new EmbedBuilder()
.setColor("White")
.setDescription(`!Bienvenido **__${member.user.username}__** a **${member.guild.name}**!`)//ponemos una descripcion para el embed
.setTimestamp()
.setThumbnail(member.user.displayAvatarURL({ dynamic: true }))

  client.channels.cache.get("1163886058258305065").send({ embeds: [alda] })
});