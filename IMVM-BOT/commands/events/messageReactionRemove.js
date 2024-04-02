const sqlite3 = require('sqlite3').verbose();
const dbSugerencias = new sqlite3.Database('./sugerencias.db');

module.exports = {
    name: 'messageReactionRemove',
    async execute(reaction, user) {
      if (reaction.partial) await reaction.fetch();
      if (user.bot) return;
  
      if (reaction.message.channel.name === 'nombre_del_canal_de_sugerencias') {
        if (reaction.emoji.name === '👍') {
         
          dbSugerencias.run('UPDATE sugerencias SET votos_positivos = votos_positivos - 1 WHERE mensaje_id = ?', [reaction.message.id], (err) => {
            if (err) {
              console.error(err);
            }
          });
  
          const originalMessage = reaction.message;
  
      
          const embed = originalMessage.embeds[0];
          const votosPositivosField = embed.fields.find((field) => field.name === 'Votos Positivos');
          const nuevoValor = parseInt(votosPositivosField.value) - 1;
          votosPositivosField.value = nuevoValor.toString();
  
         
          originalMessage.edit({ embeds: [embed] });
        } else if (reaction.emoji.name === '👎') {
         
          dbSugerencias.run('UPDATE sugerencias SET votos_negativos = votos_negativos - 1 WHERE mensaje_id = ?', [reaction.message.id], (err) => {
            if (err) {
              console.error(err);
            }
          });
  
      
          const originalMessage = reaction.message;
  
          const embed = originalMessage.embeds[0];
          const votosNegativosField = embed.fields.find((field) => field.name === 'Votos Negativos');
          const nuevoValor = parseInt(votosNegativosField.value) - 1;
          votosNegativosField.value = nuevoValor.toString();
  
        
          originalMessage.edit({ embeds: [embed] });
        }
      }
    },
};