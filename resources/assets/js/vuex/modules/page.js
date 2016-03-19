const state = {
	name: "",
	description: "",
	crumbs: []
}

const mutations = {
	SET_PAGE (state, name, description) {
		state.name = name
		state.description = description
	}
}

module.exports = {
	state,
	mutations
}