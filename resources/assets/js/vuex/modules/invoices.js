const state = {
	query: "",
	sort: {
		key: "id",
		ascending: true
	},
	sortSecond: null,
	page: 0,
	limit: 10,
	items: [],
	expandedIndex: -1,
	status: "active"
}

const mutations = {
	UPDATE_INVOICE_QUERY (state, query) {
		state.query = query
	},

	CHANGE_INVOICE_PAGE (state, page) {
		state.page = page
	},

	EXPAND_INVOICE_INDEX (state, index) {
		state.expandedIndex = index
	},

	SET_INVOICE_SORT (state, key) {
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

	SET_INVOICE_LIMIT (state, limit) {
		state.limit = limit
	},

	SET_INVOICE_STATUS (state, status) {
		state.status = status
	}
}

module.exports = {
	state,
	mutations
}