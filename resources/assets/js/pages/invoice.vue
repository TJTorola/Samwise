<template>
<div class="row" v-if="loaded">
	<div class="col-xs-12">
		<a v-link="{ path: invoice.prev }">
			<span class="col-xs-4">
				<i class="fa fa-chevron-left"></i> Prev Invoice
			</span>
		</a>

		<div class="col-xs-4 text-center" id="statusTray">
			<status-button mode="billed"
				:state="invoice.billed"
				:id="invoice.id"></status-button>
			<status-button mode="paid"
				:state="invoice.paid"
				:id="invoice.id"></status-button>
			<status-button mode="shipped"
				:state="invoice.shipped"
				:id="invoice.id"></status-button>
		</div>

		<a v-link="{ path: invoice.next }">
			<span class="col-xs-4 text-right">
				Next Invoice <i class="fa fa-chevron-right"></i>
			</span>
		</a>
	</div>

	<div class="col-xs-12">
		<toolbar-box :invoice="invoice"></toolbar-box>
	</div>

	<div class="col-xs-6">
		<customer-info-box :invoice="invoice"></customer-info-box>
	</div>

	<div class="col-xs-6">
		<cart-box :invoice="invoice"></cart-box>
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
			loaded: false,
			id: 0,
			invoice: {}
		}
	},

	route: {
		data () {
			this.loaded = false
			this.$set('id', this.$route.params.id)
			this.getInvoice()
		}
	},

	events: {
		PAID (amount) {
			this.invoice.cart.paid += amount
			this.invoice.cart.due -= amount
		}
	},

	components: {
		toolbarBox: require('app/components/invoice/toolbarBox.vue'),
		customerInfoBox: require('app/components/invoice/customerInfoBox.vue'),
		cartBox: require('app/components/invoice/cartBox.vue'),
		modifyCartBox: require('app/components/invoice/modifyCartBox.vue'),
		modifyCustomerInfoBox: require('app/components/invoice/modifyCustomerInfoBox.vue'),
		statusButton: require('app/components/invoice/statusButton.vue')
	},

	methods: {
		getInvoice() {
			this.$http.get(`invoice/${this.id}`).then(response => {
				this.$set('invoice', response.data)
				this.loaded = true
			})
		}
	}
}
</script>

<style>
#statusTray {
	font-size: larger;
	margin-bottom: 10px;
}
</style>