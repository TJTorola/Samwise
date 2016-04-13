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
			this.clearInvoice()
			this.$root.$refs.cart.clearCart()
		}
	},

	vuex: {
		actions: require('../vuex/actions/newInvoice.js')
	}
}
</script>