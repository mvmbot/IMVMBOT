const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder } = require('discord.js');
const nextClass = require('node-schedule');


module.exports = {
    data: new SlashCommandBuilder()
        .setName('nextclass')
        .setDescription('Te dice cuando es la próxima clase'),
    async execute(interaction) {
        const date = interaction.getDate();
        date.setDate(date.getDate() + 1);
        const day = date.getDay();
        const hour = date.getHours();

        const embed = new EmbedBuilder()
            .setTitle('Fecha actual')
            .setDescription(`Hora ${hour} Dia${day}`)
        embed.setColor('#F8D64E');

        await interaction.reply({ embeds: [embed] });
    },
}


/*

Crear una matriz que represente los dias y horas de la semana
En la que cada columna es un dia y fila es una hora

He de recorrer la matriz para saber en que dia y hora estamos
Comparar el dia y hora de la semana con la posición

let horas = [15,16,17,18,19,20];

var index = 0;
do {
    if (horas[index] == hour) {
            horario(dia, horas[index]);
            let exit = true;
        }
        index++;
    } while (!true || hour < 15 || hour > 20);
}
function horario(dia, horas[i]) {
    
    let dia;

    let dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    
    let matriz = [dias][];

    for (let index = 0; index < dias.length; index++) {
        if (index == dia) {
            dia = dias[index];
        }
    }
}
*/