module.exports = {
	addToCart({ dispatch }, offerId, itemId) {
		dispatch('INCRAMENT_CART_ITEM', offerId, itemId)
	},

	removeFromCart({ dispatch }, offerId, itemId) {
		dispatch('DECRAMENT_CART_ITEM', offerId, itemId)
	},
}