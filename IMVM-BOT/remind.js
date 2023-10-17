// remind.js
const schedule = require('node-schedule');

let reminderStep = {}; // Guarda el paso del recordatorio para cada usuario

module.exports = function(client) {
    client.on('messageCreate', message => {
        if (message.author.bot) return; // Ignora los mensajes de otros bots

        if (message.content.startsWith('&remind')) {
            reminderStep[message.author.id] = 1; // Inicia el proceso de recordatorio
            message.reply('Escribe tu recordatorio');
        } else if (reminderStep[message.author.id] === 1) {
            // Guarda el recordatorio del usuario
            reminderStep[message.author.id] = {
                reminder: message.content,
                step: 2
            };
            message.reply('Escribe la fecha en la que quieres que te lo recuerde (formato: DD-MM-AAAA HH:MM:SS)');
        } else if (reminderStep[message.author.id] && reminderStep[message.author.id].step === 2) {
            let dateParts = message.content.split(' ')[0].split('-');
            let timeParts = message.content.split(' ')[1].split(':');

            // Verifica que todas las partes necesarias están presentes
            if (dateParts.length === 3 && timeParts.length === 3) {
                let date = new Date(dateParts[2], dateParts[1] - 1, dateParts[0], timeParts[0], timeParts[1], timeParts[2]);

                if (!isNaN(date)) {
                    let reminder = reminderStep[message.author.id].reminder;
                    schedule.scheduleJob(date, function(){
                        // Verifica que el recordatorio exista antes de intentar acceder a su propiedad 'reminder'
                        if (client.users.cache.get(message.author.id)) {
                            client.users.cache.get(message.author.id).send(`Recordatorio: ${reminder}`);
                        }
                    });
                    message.reply('Recordatorio establecido!');
                    delete reminderStep[message.author.id]; // Elimina el recordatorio del usuario una vez establecido
                } else {
                    message.reply('Por favor, indica una fecha válida para el recordatorio.');
                }
            }
        }
    });
}