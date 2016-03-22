const state = {
	query: "",
	sort: {
		key: "id",
		ascending: true
	},
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
	},

	SET_SORT (state, key) {
		if (state.sort.key == key) {
			state.sort.ascending = !state.sort.ascending
		} else {
			state.sort.key = key
			state.sort.ascending = true
		}
	}
}

module.exports = {
	state,
	mutations
}