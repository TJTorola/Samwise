const state = {
	query: "",
	sort: {
		key: "id",
		ascending: false
	},
	sortSecond: null,
	page: 0,
	limit: 10,
	items: [],
	expandedIndex: -1
}

const mutations = {
	UPDATE_ITEM_QUERY (state, query) {
		state.query = query
	},

	CHANGE_ITEM_PAGE (state, page) {
		state.page = page
	},

	EXPAND_ITEM_INDEX (state, index) {
		state.expandedIndex = index
	},

	SET_ITEM_SORT (state, key) {
		if (state.sort.key == key) {
			state.sort.ascending = !state.sort.ascending
		} else {
			// set the previous sort as the secondary sort
			state.sortSecond = {}
			state.sortSecond.key = state.sort.key
			state.sortSecond.ascending = state.sort.ascending

			state.sort.key = key
			state.sort.ascending = true
		}
	},

	SET_ITEM_LIMIT (state, limit) {
		state.limit = limit
	}
}

module.exports = {
	state,
	mutations
}