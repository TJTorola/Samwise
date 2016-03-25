module.exports = {
	updateQuery ({ dispatch }, query) {
		dispatch('UPDATE_INVOICE_QUERY', query)
	},

	changePage ({ dispatch }, page) {
		dispatch('CHANGE_INVOICE_PAGE', page)
	},

	expandIndex({ dispatch }, index) {
		dispatch('EXPAND_INVOICE_INDEX', index)
	},

	setSort({ dispatch }, key) {
		dispatch('SET_INVOICE_SORT', key)
	},

	setLimit({ dispatch }, limit) {
		dispatch('SET_INVOICE_LIMIT', limit)
	}
}