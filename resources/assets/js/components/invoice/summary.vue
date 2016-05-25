<template>
<div class="container-fluid">
	<div class="col-md-6"> <!-- LEFT COLUMN -->
		<div class="row"> <!-- BUTTONS -->
			<div class="col-sm-6"> <!-- PRINT -->
				<print-button :invoice="invoice"></print-button>
			</div>

			<div class="col-sm-6"> <!-- CHARGE -->
				<charge-button :id="invoice.id"></charge-button>
			</div>
		</div>

		<div class="row"> <!-- MORE BUTTONS -->
			<div class="col-sm-6"> <!-- EMAIL -->
				<confirmed-button icon="fa-paper-plane" text="Email" 
					color="btn-primary"
					:action="email" 
					v-ref:email>
				</confirmed-button>
			</div>

			<div class="col-sm-6"> <!-- DELETE -->
				<confirmed-button icon="fa-trash" text="Cancel" 
					color="btn-danger"
					:action="delete" 
					v-ref:delete>
				</confirmed-button>
			</div>
		</div>

		<customer-info :invoice="invoice"></customer-info>
	</div>
	
	<div class="col-md-6"> <!-- RIGHT COLUMN -->
		<h4>Cart</h4>
		<hr>
		<invoice-items-table :cart="invoice.cart" :id="invoice.id"></invoice-items-table>

		<h4>Payments</h4>
		<hr>
		<invoice-payments :cart="invoice.cart" :payments="invoice.payments" v-if="invoice.payments.length > 0"></invoice-payments>
		<span v-else>No payments have been made.</span>
	</div>

	<div class="col-xs-12">
		<modify-info-button class="col-xs-6" :invoice="invoice"></modify-info-button>
		<modify-cart-button class="col-xs-6" :invoice="invoice"></modify-cart-button>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		InvoiceItemsTable: require('./itemsTable.vue'),
		InvoicePayments: require('./invoicePayments.vue'),
		printButton: require('./printButton.vue'),
		chargeButton: require('./charge/button.vue'),
		modifyInfoButton: require('./modifyInfo/button.vue'),
		modifyCartButton: require('./modifyCart/button.vue'),
		customerInfo: require('./customerInfo.vue'),
		confirmedButton: require('app/components/confirmedButton.vue'),
		statusIcon: require('app/components/statusIcon.vue'),
	},

	events: {
		PAID (payment) {
			this.invoice.cart.paid += payment.amount
			this.invoice.cart.due -= payment.amount
			this.invoice.payments.push(payment)
		}
	},

	methods: {
		delete () {
			this.$http.delete(`/api/invoice/${this.invoice.id}`).then(response => {
				this.$refs.delete.check()
				this.$dispatch('REFRESH')
			}, () => {
				this.$refs.delete.fail()
			})
		},

		email () {
			console.log('EMAIL')
		},

		
	}
}
</script>