const state = {
	email: '',
	phone: '',
	seperate_billing: false,
	shipping_address: {
		first_name: '',
		last_name: '',
		company: '',
		street_address_first: '',
		street_address_second: '',
		apt: '',
		zip: '',
		city: '',
		state: '',
		country: ''
	},
	billing_address: {
		first_name: '',
		last_name: '',
		company: '',
		street_address_first: '',
		street_address_second: '',
		apt: '',
		zip: '',
		city: '',
		state: '',
		country: ''
	}
}

const mutations = {
	SET_EMAIL (state, email) {
		state.email = email
	},

	SET_PHONE (state, phone) {
		state.phone = phone
	},

	SET_SEPERATE_BILLING (state, seperate_billing) {
		state.seperate_billing = seperate_billing
	},

	SET_SHIPPING (state, shipping_address) {
		state.shipping_address = shipping_address
	},

	SET_BILLING (state, billing_address) {
		state.billing_address = billing_address
	}
}

module.exports = {
	state,
	mutations
}