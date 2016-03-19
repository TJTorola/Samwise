module.exports = {
	setEvents ({ dispatch }, count) {
		dispatch('SET_EVENTS', count)
	},

	setMessages ({ dispatch }, count) {
		dispatch('SET_MESSAGES', count)
	},

	setInvoices ({ dispatch }, count) {
		dispatch('SET_INVOICES', count)
	},

	login ({ dispatch }) {
		this.$http.get('self').then(function(response) {
			dispatch('LOGIN', response.data)

			// activate newly revealed adminLTE controls
			this.$nextTick(function() {
				$.AdminLTE.pushMenu.activate("[data-toggle='offcanvas']")
				$.AdminLTE.controlSidebar.activate()
			})
		})
	},

	logout ({ dispatch }) {
		dispatch('LOGOUT')
	},

	notify ({ dispatch }, type, title, message, timeout) {
		dispatch('PUSH_NOTIFICATION', type, title, message, timeout)

		// if timeout is set, remove notification after timeout
		if (typeof timeout === 'number') {
			setTimeout(function() {
				dispatch('EXPIRE_NOTIFICATIONS')
			}, timeout)
		}
	},

	deleteNotification({ dispatch }, index)
	{
		dispatch('DELETE_NOTIFICATION', index)
	},

	setPage ({ dispatch }, name, description) {
		dispatch('SET_PAGE', name, description)
	}
}
