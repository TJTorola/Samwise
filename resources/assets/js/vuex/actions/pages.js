module.exports = {
	getPages ({dispatch}) {
		this.$http.get('pages').then(function(response) {
			dispatch('SET_PAGES', response.data)
		})
	},

	savePages ({dispatch}) {

	},

	newPage ({dispatch}, section) {

	},

	adopt ({dispatch}, child) {

	},

	disown ({dispatch}, child) {

	},

	move ({dispatch}, page, distance) {

	},

	changeSection ({dispatch}, page, newSection) {

	},

	delete ({dispatch}, page) {

	}
}