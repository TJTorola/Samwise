module.exports = {
	response (response) {
		if (response.data.note) {
			var note = response.data.note
			this.$root.notify(note.type, note.title, note.body, note.timeout)
		}

		if (response.status == 404) {
			this.$root.notify('danger', 'Not Found', 'The requested resource was not found.')
		}

		if (response.status == 422) {
			for(var title in response.data) {
				this.$root.notify('danger', title, response.data[title])
			}
		}

		if (response.status == 400) {
			if (typeof response.data.attempts_remaining == 'number' && response.data.attempts_remaining <= 0) {
				this.$root.$refs.login.resetCaptcha()
			}
		}

		if (response.status == 401) {
			this.$root.logout()
		}

		if (response.status == 429) {
			this.$root.$refs.login.resetCaptcha()
		}

		return response
	}
}