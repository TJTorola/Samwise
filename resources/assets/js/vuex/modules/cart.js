const state = {
	offers: {},
	count: 0
}

const mutations = {
	INCRAMENT_CART_ITEM (state, offerId, itemId) {
		if (state.offers[offerId]) {
			if (state.offers[offerId][itemId]) {
				state.offers[offerId][itemId]++
				state.count++
			} else {
				var Vue = require('vue')
				Vue.set(state.offers[offerId], itemId, 1)
				state.count++
			}
		} else {
			var Vue = require('vue')
			Vue.set(state.offers, offerId, {})
			Vue.set(state.offers[offerId], itemId, 1)
			state.count++
		}
	},

	DECRAMENT_CART_ITEM (state, offerId, itemId) {
		if (state.offers[offerId][itemId] && state.offers[offerId][itemId] > 0) {
			state.offers[offerId][itemId]--
			state.count--

			if (state.offers[offerId][itemId] == 0) {
				delete state.offers[offerId][itemId]
			}

			if (Object.keys(state.offers[offerId]).length === 0) {
				delete state.offers[offerId]
			}
		}
	},

	CLEAR_CART (state) {
		state.offers = {}
		state.count = 0
	}
}

module.exports = {
	state,
	mutations
}