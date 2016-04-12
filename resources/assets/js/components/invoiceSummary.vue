<template>
<div class="container-fluid">
	<div class="col-md-6"> <!-- LEFT COLUMN -->
		<div class="row"> <!-- BUTTONS -->
			<div class="col-sm-6"> <!-- PRINT -->
				<button class="btn btn-sm btn-block btn-primary" v-link="{ name: 'Print Invoice', params: { id: invoice.id }}">
					<i class="fa fa-print"></i> Print
				</button>
			</div>
			<div class="col-sm-6"> <!-- DELETE -->
				<confirmed-button icon="fa-trash" text="Cancel" 
					color="btn-danger"
					:action="delete" 
					v-ref:delete>
				</confirmed-button>
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
			<div class="col-sm-6"> <!-- CHARGE -->
				<button class="btn btn-sm btn-block btn-primary">
					<i class="fa fa-credit-card"></i> Charge
				</button>
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
		<invoice-items-table :cart="invoice.cart"></invoice-items-table>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		addressBlock: require('./addressBlock.vue'),
		confirmedButton: require('./confirmedButton.vue'),
		InvoiceItemsTable: require('./InvoiceItemsTable.vue'),
		statusIcon: require('./statusIcon.vue')
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
				this.$dispatch('REFRESH')
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