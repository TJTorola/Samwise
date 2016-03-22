module.exports = {
	updateQuery ({ dispatch }, query) {
		dispatch('UPDATE_QUERY', query)
	},

	changePage ({ dispatch }, page) {
		dispatch('CHANGE_PAGE', page)
	},

	expandIndex({ dispatch }, index) {
		dispatch('EXPAND_INDEX', index)
	},

	setSort({ dispatch }, key) {
		dispatch('SET_SORT', key)
	},

	setLimit({ dispatch }, limit) {
		dispatch('SET_LIMIT', limit)
	}
}