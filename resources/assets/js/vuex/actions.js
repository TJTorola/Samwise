var notifications = require('./actions/notificiations.js')
var status = 				require('./actions/status.js')
var user = 					require('./actions/user.js')

module.exports = Object.assign(
	notifications, 
	status, 
	user
)