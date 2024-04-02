const sqlite3 = require('sqlite3').verbose();
const dbSugerencias = new sqlite3.Database('./sugerencias.db');

module.exports = {
  name: 'messageReactionAdd',
  async execute(reaction, user) {
    if (reaction.partial) await reaction.fetch();
    if (user.bot) return;

    if (reaction.message.channel.name === 'Tu_canal_de_sugerencias') {
      if (reaction.emoji.name === '👍') {
     
        dbSugerencias.run('UPDATE sugerencias SET votos_positivos = votos_positivos + 1 WHERE mensaje_id = ?', [reaction.message.id], (err) => {
          if (err) {
            console.error(err);
          }
        });

    
        const originalMessage = reaction.message;

       
        const embed = originalMessage.embeds[0];
        const votosPositivos = embed.fields[0];
        votosPositivos.value = (parseInt(votosPositivos.value) + 1).toString(); 

       
        originalMessage.edit({ embeds: [embed] });
      } else if (reaction.emoji.name === '👎') {
       
        dbSugerencias.run('UPDATE sugerencias SET votos_negativos = votos_negativos + 1 WHERE mensaje_id = ?', [reaction.message.id], (err) => {
            if (err) {
              console.error(err);
            }
          });
          
         
          const originalMessage = reaction.message;
          
        
          const embed = originalMessage.embeds[0];
          const votosNegativos = embed.fields[1];
          votosNegativos.value = (parseInt(votosNegativos.value) + 1).toString();
          
       
          originalMessage.edit({ embeds: [embed] });
      }
    }
  },
};