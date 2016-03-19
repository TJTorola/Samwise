const state = {
	messages: 0,
	invoices: 0,
	events: 0
}

const mutations = {
	SET_MESSAGES (state, count) {
		state.messages = count
	},

	SET_INVOICES (state, count) {
		state.invoices = count
	},

	SET_EVENTS (state, count) {
		state.events = count
	}
}

module.exports = {
	state,
	mutations
}