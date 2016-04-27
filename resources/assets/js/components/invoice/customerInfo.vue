<template>
<span>
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
</span>
</template>

<script>
module.exports = {
	props: ['invoice'],

	watch: {
		'invoice.store_notes': function() {
			this.$http.patch(`/api/invoice/${this.invoice.id}`, { store_notes: this.invoice.store_notes }).then(response => {
				this.$refs.noteStatus.check()
			}, () => {
				this.$refs.noteStatus.fail()
			})
		}
	},

	components: {
		addressBlock: require('./addressBlock.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		notesKeyup() {
			this.$refs.noteStatus.working()
		}
	}
}
</script>