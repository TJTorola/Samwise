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
	status: "active",
	request: {
		_query: '',
		_page: 0,
		_limit: 10,
		_sort: JSON.stringify({ id: 'asc' }),
		_must: JSON.stringify({}),
		_must_not: JSON.stringify({ status: 'completed' })
	}
}

const helpers = {
	returnSortArray(state) {
		if (state.sort.key == 'name') {
			if (state.sort.ascending) {
				var sortArray = {
					'last_name': 'asc',
					'first_name': 'asc'
				}
			} else {
				var sortArray = {
					'last_name': 'desc',
					'first_name': 'desc'
				}
			}

			return sortArray
		}

		if (state.sort.ascending) {
			var sortArray = {}
			sortArray[state.sort.key] = 'asc'
		} else {
			var sortArray = {}
			sortArray[state.sort.key] = 'desc'
		}

		return sortArray
	},

	returnMustArray(state) {
		if (state.status == 'active' || state.status == 'all' || state.status == 'cancelled') {
			var must = {}
		} else {
			var must = {
				status: state.status
			}
		}

		return must
	},

	returnMustNotArray(state) {
		if (state.status == 'active') {
			var mustNot = {
				status: 'completed'
			}
		} else {
			var mustNot = {}
		}

		return mustNot
	},

	returnRequest(state) {
		var sortArray = this.returnSortArray(state)
		var must 			= this.returnMustArray(state)
		var mustNot 	= this.returnMustNotArray(state)

		return {
			_query: state.query,
			_page: state.page,
			_limit: state.limit,
			_sort: JSON.stringify(sortArray),
			_must: JSON.stringify(must),
			_must_not: JSON.stringify(mustNot)
		}
	}
}

const mutations = {
	UPDATE_INVOICE_QUERY (state, query) {
		state.query = query
		state.request = helpers.returnRequest(state)
	},

	CHANGE_INVOICE_PAGE (state, page) {
		state.page = page
		state.request = helpers.returnRequest(state)
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
		state.request = helpers.returnRequest(state)
	},

	SET_INVOICE_LIMIT (state, limit) {
		state.limit = limit
		state.request = helpers.returnRequest(state)
	},

	SET_INVOICE_STATUS (state, status) {
		state.status = status
		state.request = helpers.returnRequest(state)
	}
}

module.exports = {
	state,
	mutations
}