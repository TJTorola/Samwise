const state = {
	email: '',
	phone: '',
	seperate_billing: false,
	shipping_address: {
		first_name: '',
		last_name: '',
		company: '',
		street: '',
		street_second: '',
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
		street: '',
		street_second: '',
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

	SET_SHIPPING_ADDRESS (state, shipping_address) {
		state.shipping_address = shipping_address
	},

	SET_BILLING_ADDRESS (state, billing_address) {
		state.billing_address = billing_address
	},

	CLEAR_INVOICE (state) {
		state.email = ''
		state.phone = ''
		state.seperate_billing = false
		state.shipping_address = {
			first_name: '',
			last_name: '',
			company: '',
			street: '',
			street_second: '',
			apt: '',
			zip: '',
			city: '',
			state: '',
			country: ''
		}
		state.billing_address = {
			first_name: '',
			last_name: '',
			company: '',
			street: '',
			street_second: '',
			apt: '',
			zip: '',
			city: '',
			state: '',
			country: ''
		}
	}
}

module.exports = {
	state,
	mutations
}