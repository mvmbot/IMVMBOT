const {google} = require('googleapis');

const oauth2Client = new google.auth.OAuth2(
  YOUR_CLIENT_ID,
  YOUR_CLIENT_SECRET,
  YOUR_REDIRECT_URL
);

oauth2Client.setCredentials({access_token: YOUR_ACCESS_TOKEN});

const classroom = google.classroom({version: 'v1', auth: oauth2Client});

function listCourses(callback) {
  classroom.courses.list({
    pageSize: 10,
  }, callback);
}

function listCourseWork(courseId, callback) {
  classroom.courses.courseWork.list({
    courseId: courseId,
  }, callback);
}

module.exports = {
  listCourses,
  listCourseWork,
};

client.on('message', msg => {
  if (msg.content.startsWith('&classroom')) {
    const courseId = msg.content.split(' ')[1];
    classroom.listCourseWork(courseId, (err, res) => {
      if (err) return console.error('The API returned an error: ' + err);
      const courseWork = res.data.courseWork;
      if (courseWork && courseWork.length) {
        let reply = 'Course Work:\n';
        courseWork.forEach((work) => {
          reply += `${work.title} (${work.id})\n`;
        });
        msg.reply(reply);
      } else {
        msg.reply('No course work found.');
      }
    });
  }
});
