const state = {
	query: "",
	sort: "",
	ascending: true,
	page: 0,
	limit: 10,
	items: [],
	expandedIndex: -1
}

const mutations = {
	UPDATE_QUERY (state, query) {
		state.query = query
	},

	CHANGE_PAGE (state, page) {
		state.page = page
	},

	EXPAND_INDEX (state, index) {
		state.expandedIndex = index
	}
}

module.exports = {
	state,
	mutations
}