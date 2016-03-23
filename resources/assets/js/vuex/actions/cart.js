module.exports = {
	addToCart({ dispatch }, variantId) {
		dispatch('ADD_TO_CART', variantId)
		// this.$http.get('variant/'+variantId).then(function(response) {
		// 	console.log(response)
		// 	dispatch('ADD_VARIANT_TO_CART', response.data)
		// })
	},

	removeFromCart({ dispatch }, variantId) {
		dispatch('REMOVE_FROM_CART', variantId)
	}
}