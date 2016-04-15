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
	expandedIndex: -1,
	request: {
		_query: '',
		_page: 0,
		_limit: 10,
		_sort: JSON.stringify({ id: 'desc' })
	}
}

const helpers = {
	returnSortArray(state) {
		if (state.sort.ascending) {
			var sortArray = {}
			sortArray[state.sort.key] = 'asc'
		} else {
			var sortArray = {}
			sortArray[state.sort.key] = 'desc'
		}

		return sortArray
	},

	returnRequest(state) {
		var sortArray = this.returnSortArray(state)

		return {
			_query: state.query,
			_page: state.page,
			_limit: state.limit,
			_sort: JSON.stringify(sortArray)
		}
	}
}

const mutations = {
	UPDATE_OFFER_QUERY (state, query) {
		state.query = query
		state.request = helpers.returnRequest(state)
	},

	CHANGE_OFFER_PAGE (state, page) {
		state.page = page
		state.request = helpers.returnRequest(state)
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
		state.request = helpers.returnRequest(state)
	},

	SET_OFFER_LIMIT (state, limit) {
		state.limit = limit
		state.request = helpers.returnRequest(state)
	}
}

module.exports = {
	state,
	mutations
}