var Vue = require('vue')
var Vuex = require('vuex')

Vue.use(Vuex)

const state = {
	status: {
		notifications: [],
		messages: 0,
		invoices: 0,
		events: 0
	},
	page: {
		name: "",
		description: "",
		crumbs: []
	},
	user: {},
	cart: {
		items: []
	}
}

const mutations = {
	SET_MESSAGES (state, count) {
		state.status.messages = count
	},

	SET_INVOICES (state, count) {
		state.status.invoices = count
	},

	SET_EVENTS (state, count) {
		state.status.events = count
	},

	LOGIN (state, user) {
		state.user = user
	},

	LOGOUT (state) {
		state.user = {}
	},

	PUSH_NOTIFICATION (state, type, title, message, timeout) {
		if (typeof timeout == 'number') {
			var expires = Date.now() + timeout
		} else {
			var expires = null
		}

		state.status.notifications.push({
			type: type,
			name: name,
			message: message,
			expires: expires
		})
	},

	EXPIRE_NOTIFICATIONS (state) {
		var now = Date.now()

		for (var i = state.status.notifications.length - 1; i >= 0; i--) {
			if (state.status.notifications[i]['expires'] <= now) {
				state.status.notifications.splice(i, 1)
			}
		}
	},

	DELETE_NOTIFICATION (state, index) {
		state.status.notifications.splice(index, 1)
	},

	SET_PAGE (state, name, description) {
		state.page.name = name
		state.page.description = description
	}
}

module.exports = new Vuex.Store({
	state,
	mutations
})
