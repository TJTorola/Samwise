const state = {
	query: "",
	sort: "",
	ascending: true,
	page: 1,
	limit: 10,
	items: []
}

const mutations = {
	UPDATE_QUERY (state, query) {
		state.query = query
	}
}

module.exports = {
	state,
	mutations
}