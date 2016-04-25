<template>
<div class="row">
	<div class="col-xs-12">
		<toolbar-box></toolbar-box>
	</div>

	<div class="col-xs-6">
		<customer-info-box></customer-info-box>
	</div>

	<div class="col-xs-6">
		<cart-box></cart-box>
	</div>

	<div class="col-xs-12">
		<modify-cart-box></modify-cart-box>
	</div>

	<div class="col-xs-12">
		<modify-customer-info-box></modify-customer-info-box>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			id: 0,
			invoice: {}
		}
	},

	route: {
		data () {
			this.$set('id', this.$route.params.id)
			this.getInvoice()
		}
	},

	components: {
		toolbarBox: require('app/components/invoice/toolbarBox.vue'),
		customerInfoBox: require('app/components/invoice/customerInfoBox.vue'),
		cartBox: require('app/components/invoice/cartBox.vue'),
		modifyCartBox: require('app/components/invoice/modifyCartBox.vue'),
		modifyCustomerInfoBox: require('app/components/invoice/modifyCustomerInfoBox.vue')
	},

	methods: {
		getInvoice() {
			this.$http.get(`invoice/${this.id}`).then(response => {
				this.$set('invoice', response.data)
			})
		}
	}
}
</script>