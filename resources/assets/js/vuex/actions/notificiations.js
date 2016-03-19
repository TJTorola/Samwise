module.exports = {
	notify ({ dispatch }, type, title, message, timeout) {
		dispatch('PUSH_NOTIFICATION', type, title, message, timeout)

		// if timeout is set, remove notification after timeout
		if (typeof timeout === 'number') {
			setTimeout(function() {
				dispatch('EXPIRE_NOTIFICATIONS')
			}, timeout)
		}
	},

	deleteNotification({ dispatch }, index) {
		dispatch('DELETE_NOTIFICATION', index)
	},
}