module.exports = {
	updateQuery ({ dispatch }, query) {
		dispatch('UPDATE_OFFER_QUERY', query)
	},

	changePage ({ dispatch }, page) {
		dispatch('CHANGE_OFFER_PAGE', page)
	},

	expandIndex({ dispatch }, index) {
		dispatch('EXPAND_OFFER_INDEX', index)
	},

	setSort({ dispatch }, key) {
		dispatch('SET_OFFER_SORT', key)
	},

	setLimit({ dispatch }, limit) {
		dispatch('SET_OFFER_LIMIT', limit)
	}
}