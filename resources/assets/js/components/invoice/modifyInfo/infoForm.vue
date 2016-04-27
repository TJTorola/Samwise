<template>
<div class="form-horizontal">
	<div class="col-md-12">
		<b>Contact Info</b>
		<hr>

		<div class="form-group">
			<label for="email" class="col-md-4 control-label">E-Mail</label>
			<div class="col-md-8">
				<input type="text" class="form-control" id="email" placeholder="*" 
					v-model="email">
			</div>
		</div>

		<div class="form-group">
			<label for="phone" class="col-md-4 control-label">Phone Number</label>
			<div class="col-md-8">
				<input type="text" class="form-control" id="phone"
					v-mask mask="(###) ###-#### x#####"
					:mask-input="setPhone"
					:value="phone">
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-8 col-md-offset-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" id="seperate_billing"
							v-model="seperateBilling"> Seperate Billing/Shipping
					</label>
				</div>
			</div>
		</div>
	</div>
	<contact-fields class="col-md-6" 
		label="Shipping Info" 
		:info="shippingAddress"
		:disabled="false"
		v-ref:shipping-input></contact-fields>

	<contact-fields class="col-md-6" 
		label="Billing Info" 
		:info="billingAddress" 
		:disabled="!seperateBilling"
		v-ref:billing-input></contact-fields>
</div>
</template>

<script>
module.exports = {
	props: ['phone', 'email', 'seperateBilling', 'shippingAddress', 'billingAddress'],

	components: {
		contactFields: require('../contactFields.vue'),
	},

	methods: {
		setPhone(phone) {
			this.phone = phone
		}
	}
}
</script>