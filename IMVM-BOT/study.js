// study.js
const schedule = require('node-schedule');

let studyStep = {}; // Guarda el paso del estudio para cada usuario

module.exports = function(client) {
    client.on('message', message => {
        if (message.author.bot) return; // Ignora los mensajes de otros bots

        if (message.content.startsWith('&study')) {
            studyStep[message.author.id] = 1; // Inicia el proceso de estudio
            message.reply('Por favor, introduce un tiempo de estudio.');
        } else if (studyStep[message.author.id] === 1) {
            // Guarda el tiempo de estudio del usuario
            let time = parseInt(message.content);
            if (isNaN(time)) {
                message.reply('Por favor, introduce un número válido de minutos.');
                return;
            }
            studyStep[message.author.id] = {
                time: time,
                step: 2
            };
            message.reply(`Estudia durante ${time} minutos. Te echaré del canal de voz cuando el tiempo se acabe.`);
        } else if (studyStep[message.author.id] && studyStep[message.author.id].step === 2) {
            let voiceChannel = message.member.voice.channel;
            if (!voiceChannel) {
                message.reply('Debes estar en un canal de voz para usar este comando.');
                return;
            }
            let date = new Date();
            date.setMinutes(date.getMinutes() + studyStep[message.author.id].time);
            schedule.scheduleJob(date, function(){
                voiceChannel.leave();
                if (client.users.cache.get(message.author.id)) {
                    client.users.cache.get(message.author.id).send('¡Tiempo de estudio terminado!');
                }
            });
            delete studyStep[message.author.id]; // Elimina el paso de estudio del usuario
        }
    });
};
