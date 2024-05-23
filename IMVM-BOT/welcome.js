/*
 * File: welcome
 * Author: Iván Sáez
 * Github: https://github.com/ivanmvm
 * Desc:
 */

const { Client } = require("discord.js");
const client = new Client();

client.on('guildMemberAdd', (member) => {
const { EmbedBuilder } = require('discord.js');//definimos discord/EmbedBuilder

const alda = new EmbedBuilder()//ponemos el nombre del embed
.setColor("White")//ponemos que color sera el embed
.setDescription(`!Bienvenido **__${member.user.username}__** a **${member.guild.name}**!`)//ponemos una descripcion para el embed
.setTimestamp()//tiempo en el embed
.setThumbnail(member.user.displayAvatarURL({ dynamic: true }))//avatar del user

  client.channels.cache.get("1163886058258305065").send({ embeds: [alda] })
});