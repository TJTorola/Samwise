module.exports = {
	setEmail ({ dispatch }, e) {
		dispatch('SET_EMAIL', e.target.value)
	},

	setPhone ({ dispatch }, e) {
		dispatch('SET_PHONE', e.target.value)
	},

	setSeperateBilling ({ dispatch }, e) {
		dispatch('SET_SEPERATE_BILLING', e.target.value)
	},

	setShippingAddress ({ dispatch }, shipping_address) {
		dispatch('SET_SHIPPING_ADDRESS', shipping_address)
	},

	setBillingAddress ({ dispatch }, billing_address) {
		dispatch('SET_BILLING_ADDRESS', billing_address)
	}
}