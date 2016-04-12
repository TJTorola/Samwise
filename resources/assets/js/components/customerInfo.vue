<template>
<div class="col-xs-12">
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-user"></i> Customer Info</h3>

			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			<div class="form-horizontal">
				<div class="col-md-12">
					<b>Contact Info</b>
					<hr>

					<div class="form-group">
						<label for="email" class="col-md-4 control-label">E-Mail</label>
						<div class="col-md-8">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" id="email" placeholder="*" 
									debounce="500"
									:value="email" 
									@input="emailInput">

								<div class="input-group-btn">
									<button type="submit" class="btn btn-default" 
										@click="fillFromEmail"
										:disabled="!validEmail">
										<status-icon icon="fa-search" v-ref:search></status-icon>
									</button>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label for="phone" class="col-md-4 control-label">Phone Number</label>
						<div class="col-md-8">
							<input type="text" class="form-control" id="phone"
								:mask-input="setPhone"
								v-mask="(###) ###-#### x#####"
								:value="phone">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-8 col-md-offset-4">
							<div class="checkbox">
								<label>
									<input type="checkbox" id="seperate_billing"
										:checked="seperate_billing"
										@change="seperateBillingInput"> Seperate Billing/Shipping
								</label>
							</div>
						</div>
					</div>
				</div>
				<contact-fields class="col-md-6" 
					label="Shipping Info" 
					:info="shipping_address"
					:disabled="false"
					@input="shippingInput"
					v-ref:shipping-input></contact-fields>

				<contact-fields class="col-md-6" 
					label="Billing Info" 
					:info="billing_address" 
					:disabled="!seperate_billing"
					@input="billingInput"
					v-ref:billing-input></contact-fields>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		contactFields: require('./contactFields.vue'),
		statusIcon: require('./statusIcon.vue')
	},

	computed: {
		validEmail() {
			return (/\S+@\S+\.\S+/.test(this.email))
		}
	},

	methods: {
		emailInput(e) {
			this.setEmail(e.target.value)
		},

		seperateBillingInput(e) {
			this.setSeperateBilling(e.target.checked)
		},

		shippingInput() {
			this.setShippingAddress(this.$refs.shippingInput.info)
		},

		billingInput() {
			this.setShippingAddress(this.$refs.shippingInput.info)
		},

		fillFromEmail() {
			this.$refs.search.working()
			var query = {
				_query: this.email.split('.').join(' '),
				_limit: 1,
				_sort: JSON.stringify({ id: 'desc' }) 
			}

			this.$http.get('invoices', query).then(function(response) {
				if (response.data.body.length) {
					this.$refs.search.check()
					var most_recent = response.data.body[0]
					this.setShippingAddress(most_recent.shipping_address)
					this.setBillingAddress(most_recent.billing_address)
					this.setPhone(most_recent.phone)
					this.setSeperateBilling(most_recent.seperate_billing)
				} else {
					this.$refs.search.fail()
					this.$root.notify('info', 'No Invoice Found', 'No invoices were found from that email.', 5000)
				}
			})
		}
	},

	vuex: {
		getters: {
			email: state => state.newInvoice.email,
			phone: state => state.newInvoice.phone,
			seperate_billing: state => state.newInvoice.seperate_billing,
			shipping_address: state => state.newInvoice.shipping_address,
			billing_address: state => state.newInvoice.billing_address
		},

		actions: require('../vuex/actions/newInvoice.js')
	}
}
</script>