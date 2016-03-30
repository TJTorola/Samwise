var Vue = require('vue')
var Vuex = require('vuex')

var authentication = 	require('./modules/authentication.js')
var cart = 						require('./modules/cart.js')
var offers = 					require('./modules/offers.js')
var invoices = 				require('./modules/invoices.js')
var notifications = 	require('./modules/notifications.js')
var page = 						require('./modules/page.js')
var status = 					require('./modules/status.js')
var user = 						require('./modules/user.js')

Vue.use(Vuex)

module.exports = new Vuex.Store({
	modules: {
		authentication,
		cart,
		offers,
		invoices,
		notifications,
		page,
		status,
		user
	}
})
