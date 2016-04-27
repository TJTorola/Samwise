<template>
<div class="lightbox-mask" v-show="show" transition="lightbox">
	<div class="lightbox-wrapper">
		<div class="lightbox-container" id="infoLightbox">
			<div class="lightbox-header">
				<i class="fa fa-user"></i> Modify Customer Info <br>
				<i class="u-thin">Modify the invoice customer information.</i>
			</div>
			<div class="lightbox-body">
				<info-form
					:phone.sync="invoice.phone"
					:email.sync="invoice.email"
					:seperate-billing.sync="invoice.seperate_billing"
					:shipping-address.sync="invoice.shipping_address"
					:billing-address.sync="invoice.billing_address">
				</info-form>
			</div>

			<div class="lightbox-footer">
				<button class="btn btn-sm btn-primary" @click="save">
					<status-icon icon="fa-floppy-o" v-ref:save></status-icon> save
				</button>

				<button class="btn btn-sm pull-right" @click="show = false">
					<i class="fa fa-times"></i> Cancel
				</button>
			</div>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['show', 'invoice'],

	components: {
		infoForm: require('./infoForm.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		save () {
			this.$refs.save.working()

			var request = {
				phone: this.invoice.phone,
				email: this.invoice.email,
				seperate_billing: this.invoice.seperate_billing,
				shipping_address: this.invoice.shipping_address,
				billing_address: this.invoice.billing_address
			}

			this.$http.patch(`invoice/${this.invoice.id}`, request).then(response => {
				this.$refs.save.check()
				this.$dispatch('GET')
				this.show = false
			}, () => {
				this.$refs.save.fail()
			})
		}
	}
}
</script>

<style>
#infoLightbox {
	width: 90%;
}
</style>