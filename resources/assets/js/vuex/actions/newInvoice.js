module.exports = {
	setEmail ({ dispatch }, email) {
		dispatch('SET_EMAIL', email)
	},

	setPhone ({ dispatch }, phone) {
		dispatch('SET_PHONE', phone)
	},

	setSeperateBilling ({ dispatch }, seperate_billing) {
		dispatch('SET_SEPERATE_BILLING', seperate_billing)
	},

	setShippingAddress ({ dispatch }, shipping_address) {
		dispatch('SET_SHIPPING_ADDRESS', shipping_address)
	},

	setBillingAddress ({ dispatch }, billing_address) {
		dispatch('SET_BILLING_ADDRESS', billing_address)
	},

	clearInvoice({ dispatch }) {
		dispatch('CLEAR_INVOICE')
	}
}