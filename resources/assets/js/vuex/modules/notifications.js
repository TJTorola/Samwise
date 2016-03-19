const state = []

const mutations = {
	PUSH_NOTIFICATION (state, type, title, message, timeout) {
		if (typeof timeout == 'number') {
			var expires = Date.now() + timeout
		} else {
			var expires = null
		}

		state.push({
			type: type,
			name: name,
			message: message,
			expires: expires
		})
	},

	EXPIRE_NOTIFICATIONS (state) {
		var now = Date.now()

		for (var i = state.length - 1; i >= 0; i--) {
			if (state[i]['expires'] <= now) {
				state.splice(i, 1)
			}
		}
	},

	DELETE_NOTIFICATION (state, index) {
		state.splice(index, 1)
	}
}

module.exports = {
	state,
	mutations
}