const state = {
	info: {},
	todos: []
}

const mutations = {
	SET_USER (state, user) {
		state.info = user
	},

	DELETE_USER (state) {
		state.info = {}
	}
}

module.exports = {
	state,
	mutations
}