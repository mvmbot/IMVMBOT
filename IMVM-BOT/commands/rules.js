// rules.js
const { SlashCommandBuilder } = require('@discordjs/builders');
const { EmbedBuilder } = require('discord.js');

const rulesText = `
**Respect:**
- Treat everyone with respect and courtesy.
- Avoid insults, offensive arguments, or any harmful behavior.

**Appropriate Content:**
- Post only content suitable for all ages.
- Avoid offensive, discriminatory, or illegal material.

**Spam and Flood:**
- Do not spam or flood channels with unnecessary messages.
- Avoid excessive use of mentions to other users.

**Advertising:**
- Do not promote other Discord servers or products without permission.
- Advertising school events is allowed but should be done in moderation.

**Proper Channel Usage:**
- Use the appropriate channels for each type of content (e.g., general, studies, events, etc.).

**School Identification:**
- Use a recognizable username related to your school identity.

**Bot Usage:**
- Do not use bots abusively or for harmful actions.
- Consult with administrators before adding new bots to the server.

**Collaboration:**
- Collaborate and participate positively in server conversations and projects.

**Privacy:**
- Respect the privacy of others. Do not share personal information without consent.

**Issues and Complaints:**
- If you have problems, questions, or complaints, contact administrators via private messages.

**Updates and Announcements:**
- Stay informed about updates and announcements through designated channels.

**Consequences:**
- Violating these rules may result in warnings, temporary or permanent bans, depending on the severity.
`;

module.exports = {
    data: new SlashCommandBuilder()
        .setName('rules')
        .setDescription('Show the IMVM BOT rules'),
    async execute(interaction) {
        // Create EmbedBuilder
        const embed = new EmbedBuilder()
            .setColor('#0099ff')
            .setTitle('IMVMBOT Rules')
            .setDescription(rulesText);

        // Interaction with embed
        await interaction.reply({ embeds: [embed] });
    },
};
