<template>
<div class="row">
	<modify-cart></modify-cart>

	<customer-info></customer-info>

	<div class="col-xs-8 col-xs-offset-2">
		<button type="button" class="btn btn-block btn-sm btn-primary" @click="submit">
			<i class="fa fa-plus"></i> Submit Invoice
		</button>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		modifyCart: require('../components/modifyCart.vue'),
		customerInfo: require('../components/customerInfo.vue')
	},

	methods: {
		submit () {
			var request = {
				cart: this.offers,
				email: this.email,
				phone: this.phone,
				seperate_billing: this.seperate_billing,
				shipping_address: this.shipping_address,
				billing_address: this.billing_address
			}

			this.$http.post('invoice', request).then(response => {
				this.clearInvoice()
				this.$root.$refs.cart.clearCart()
			})
		}
	},

	vuex: {
		getters: {
			offers: state => state.cart.offers,
			email: state => state.newInvoice.email,
			phone: state => state.newInvoice.phone,
			seperate_billing: state => state.newInvoice.seperate_billing,
			shipping_address: state => state.newInvoice.shipping_address,
			billing_address: state => state.newInvoice.billing_address,
		},

		actions: require('../vuex/actions/newInvoice.js')
	}
}
</script>