<template>
<div class='box box-primary collapsed-box'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-user" v-ref:status></status-icon> Modify Customer Info
		</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
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
								v-model="invoice.email">
						</div>
					</div>
				</div>

				<div class="form-group">
					<label for="phone" class="col-md-4 control-label">Phone Number</label>
					<div class="col-md-8">
						<input type="text" class="form-control" id="phone"
							v-mask mask="(###) ###-#### x#####"
							:mask-input="setPhone"
							:value="invoice.phone">
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
				:info="invoice.shipping_address"
				:disabled="false"
				v-ref:shipping-input></contact-fields>

			<contact-fields class="col-md-6" 
				label="Billing Info" 
				:info="invoice.billing_address" 
				:disabled="!invoice.seperate_billing"
				v-ref:billing-input></contact-fields>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		setPhone(phone) {
			this.invoice.phone = phone
		}
	}
}
</script>