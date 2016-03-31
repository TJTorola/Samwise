const state = {
	loaded: false,
	modified: false,
	header: [],
	footer: [],
	hidden: [],
	deleted: []
}

const mutations = {
	SET_PAGES (state, pages) {
		state.header = pages.header
		state.footer = pages.footer
		state.hidden = pages.hidden
		state.deleted = []
		state.loaded = true
		state.modified = false
	},

	DELETE_PAGE (state, id) {
		state.deleted.push(id)
		// TODO, Splice id from pages array
	}
}

module.exports = {
	state,
	mutations
}