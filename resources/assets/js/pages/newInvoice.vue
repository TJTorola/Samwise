<template>
<div class="row">
	<modify-cart></modify-cart>

	<customer-info></customer-info>

	<div class="col-xs-8 col-xs-offset-2">
		<button type="button" class="btn btn-block btn-sm btn-primary" @click="submit">
			<status-icon icon="fa-plus" v-ref:submit></status-icon> Submit Invoice
		</button>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		modifyCart: require('app/components/cart/modifyCart.vue'),
		customerInfo: require('app/components/invoice/customerInfoForm.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		submit () {
			this.$refs.submit.working()
			var request = {
				cart: this.offers,
				email: this.email,
				phone: this.phone,
				seperate_billing: this.seperate_billing,
				shipping_address: this.shipping_address,
				billing_address: this.billing_address
			}

			this.$http.post('invoice/admin', request).then(response => {
				this.$refs.submit.check()
				this.clearInvoice()
				this.$root.$refs.cart.clearCart()
				this.$router.go({ path: `invoices` })
			}, () => {
				this.$refs.submit.fail()
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

		actions: require('app/vuex/actions/newInvoice.js')
	}
}
</script>
