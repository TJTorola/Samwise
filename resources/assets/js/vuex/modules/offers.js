const state = {
	query: "",
	sort: {
		key: "id",
		ascending: false
	},
	sortSecond: null,
	page: 0,
	limit: 10,
	offers: [],
	expandedIndex: -1
}

const mutations = {
	UPDATE_OFFER_QUERY (state, query) {
		state.query = query
	},

	CHANGE_OFFER_PAGE (state, page) {
		state.page = page
	},

	EXPAND_OFFER_INDEX (state, index) {
		state.expandedIndex = index
	},

	SET_OFFER_SORT (state, key) {
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

	SET_OFFER_LIMIT (state, limit) {
		state.limit = limit
	}
}

module.exports = {
	state,
	mutations
}