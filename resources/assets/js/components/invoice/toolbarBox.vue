<template>
<div class='box box-success'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-wrench" v-ref:status></status-icon> Invoice Tools
		</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<div class="col-md-3 col-xs-6">
			<print-button :invoice="invoice"></print-button>
		</div>

		<div class="col-md-3 col-xs-6">
			<confirmed-button icon="fa-paper-plane" text="Email" 
				color="btn-primary"
				:action="email" 
				v-ref:email>
			</confirmed-button>
		</div>

		<div class="col-md-3 col-xs-6">
			<charge-button :id="invoice.id"></charge-button>
		</div>

		<div class="col-md-3 col-xs-6">
			<confirmed-button icon="fa-trash" text="Cancel" 
				color="btn-danger"
				:action="delete" 
				v-ref:delete>
			</confirmed-button>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		statusIcon: require('app/components/statusIcon.vue'),
		confirmedButton: require('app/components/confirmedButton.vue'),
		printButton: require('./printButton.vue'),
		chargeButton: require('./charge/button.vue')
	}
}
</script>