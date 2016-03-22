module.exports = {
	updateQuery ({ dispatch }, query) {
		dispatch('UPDATE_QUERY', query)
	},

	changePage ({ dispatch }, page) {
		dispatch('CHANGE_PAGE', page)
	},

	expandIndex({ dispatch }, index) {
		dispatch('EXPAND_INDEX', index)
	}
}