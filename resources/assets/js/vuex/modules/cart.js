const state = {
	items: {},
	count: 0
}

const mutations = {
	ADD_TO_CART (state, variantId) {
		if (state.items[variantId]) {
			state.items[variantId]++
			state.count++
		} else {
			state.items[variantId] = 1
			state.count++
		}
	},

	REMOVE_FROM_CART (state, variantId) {
		if (state.items[variantId] && state.items[variantId] > 0) {
			state.items[variantId] -= 1
			state.count--
		}
	}
}

module.exports = {
	state,
	mutations
}