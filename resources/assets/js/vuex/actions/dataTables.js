module.exports = {
	updateQuery ({ dispatch }, location, query) {
		if (location == 'invoices') {
			dispatch('UPDATE_INVOICE_QUERY', query)
		} else if (location == 'offers') {
			dispatch('UPDATE_OFFER_QUERY', query)
		}
	},

	changePage ({ dispatch }, location, page) {
		if (location == 'invoices') {
			dispatch('CHANGE_INVOICE_PAGE', page)
		} else if (location == 'offers') {
			dispatch('CHANGE_OFFER_PAGE', page)
		}
	},

	expandIndex({ dispatch }, location, index) {
		dispatch('EXPAND_INVOICE_INDEX', index)

		if (location == 'invoices') {
			dispatch('EXPAND_INVOICE_INDEX', index)
		} else if (location == 'offers') {
			dispatch('EXPAND_OFFER_INDEX', index)
		}
	},

	setSort({ dispatch }, location, key) {
		if (location == 'invoices') {
			dispatch('SET_INVOICE_SORT', key)
		} else if (location == 'offers') {
			dispatch('SET_OFFER_SORT', key)
		}
	},

	setLimit({ dispatch }, location, limit) {
		if (location == 'invoices') {
			dispatch('SET_INVOICE_LIMIT', limit)
		} else if (location == 'offers') {
			dispatch('SET_OFFER_LIMIT', limit)
		}
	},

	setStatus({ dispatch }, status) {
		dispatch('SET_INVOICE_STATUS', status)
	}
}