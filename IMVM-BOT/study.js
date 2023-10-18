// study.js 
const schedule = require('node-schedule');

let studyStep = {}; // Guarda el paso del estudio para cada usuario

module.exports = function(client) {
  client.on('messageCreate', message => { 
 if (message.author.bot) return; // Ignora los mensajes de otros bots

 if (message.content.startsWith('&study')) {
    studyStep[message.author.id] = 1; // Inicia el proceso de estudio
    message.reply('¿Cuánto tiempo quieres estudiar? (formato: HH:MM:SS)');
} else if (studyStep[message.author.id] === 1) {
    let timeParts = message.content.split(':');

    // Verifica que todas las partes necesarias están presentes
    if (timeParts.length === 3) {
        let date = new Date();
        date.setHours(date.getHours() + parseInt(timeParts[0]));
        date.setMinutes(date.getMinutes() + parseInt(timeParts[1]));
        date.setSeconds(date.getSeconds() + parseInt(timeParts[2]));

        if (!isNaN(date)) {
            schedule.scheduleJob(date, function(){
                // Verifica que el usuario exista antes de intentar enviar el mensaje
                if (client.users.cache.get(message.author.id)) {
                    client.users.cache.get(message.author.id).send(`¡Tiempo de estudio terminado!`);
                }
            });
            message.reply('¡Temporizador de estudio establecido!');
            delete studyStep[message.author.id]; // Elimina el paso de estudio para el usuario
        } else {
            message.reply('Por favor, ingresa un tiempo válido.');
        }
    } else {
        message.reply('Por favor, ingresa un tiempo válido.');
    }
}
});
};