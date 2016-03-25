module.exports = {
	updateQuery ({ dispatch }, query) {
		dispatch('UPDATE_ITEM_QUERY', query)
	},

	changePage ({ dispatch }, page) {
		dispatch('CHANGE_ITEM_PAGE', page)
	},

	expandIndex({ dispatch }, index) {
		dispatch('EXPAND_ITEM_INDEX', index)
	},

	setSort({ dispatch }, key) {
		dispatch('SET_ITEM_SORT', key)
	},

	setLimit({ dispatch }, limit) {
		dispatch('SET_ITEM_LIMIT', limit)
	}
}