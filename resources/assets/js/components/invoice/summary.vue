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

		<h4 v-if="!invoice.sepearate_billing">Shipping/Billing Address</h4>
		<h4 v-else>Shipping Address</h4>
		<hr>
		<address-block :address="invoice.shipping_address"></address-block>

		<span v-if="invoice.seperate_billing">
			<h4>Billing Address</h4>
			<hr>
			<address-block :address="invoice.billing_address"></address-block>
		</span>

		<hr>

		<section v-if="invoice.notes">
			<b>Customer Notes:</b>
			<div class="attachment-block clearfix">
				{{{ invoice.notes | nl2br }}}
			</div>
		</section>

		<div class="form-group">
      <label>Store Notes:</label> <small><status-icon icon="" v-ref:note-status></status-icon></small>
      <textarea class="form-control" rows="6" placeholder="Enter ..." 
      	v-model="invoice.store_notes" 
      	debounce="500" 
      	@keyup="notesKeyup">
      </textarea>
    </div>
	</div>
	
	<div class="col-md-6"> <!-- RIGHT COLUMN -->
		<invoice-items-table :cart="invoice.cart" :id="invoice.id"></invoice-items-table>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		addressBlock: require('./addressBlock.vue'),
		InvoiceItemsTable: require('./itemsTable.vue'),
		printButton: require('./printButton.vue'),
		chargeButton: require('./charge/button.vue'),
		confirmedButton: require('app/components/confirmedButton.vue'),
		statusIcon: require('app/components/statusIcon.vue'),
	},

	watch: {
		'invoice.store_notes': function() {
			this.$http.patch(`/api/invoice/${this.invoice.id}`, { store_notes: this.invoice.store_notes }).then(response => {
				this.$refs.noteStatus.check()
			}, () => {
				this.$refs.noteStatus.fail()
			})
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

		notesKeyup () {
			this.$refs.noteStatus.working()
		}
	}
}
</script>