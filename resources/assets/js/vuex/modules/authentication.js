const state = ""

const mutations = {
	SET_TOKEN (state, token) {
		state = token
	},

	DELETE_TOKEN (state) {
		state = ""
	}
}

module.exports = {
	state,
	mutations
}