<template>
<div class='box box-info'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-user" v-ref:status></status-icon> Customer Info
		</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<customer-info :invoice="invoice"></customer-info>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		addressBlock: require('./addressBlock.vue'),
		customerInfo: require('./customerInfo.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		notesKeyup () {
			this.$refs.noteStatus.working()
		}
	}
}
</script>