<template>
<ul class="nav nav-tabs">
	<li :class="(status == 'all')?'active':'u-pointer'" 
		@click="statusInput('all')" style="margin-left: 10px;">
		<a>All</a>
	</li>
	<li :class="(status == 'active')?'active':'u-pointer'" 
		@click="statusInput('active')">
		<a>Active</a>
	</li>
	<li class="hidden-xs" :class="(status == 'new')?'active':'u-pointer'" 
		@click="statusInput('new')">
		<a>New</a>
	</li>
	<li class="hidden-xs" :class="(status == 'billed')?'active':'u-pointer'" 
		@click="statusInput('billed')">
		<a>Billed</a>
	</li>
	<li class="hidden-xs" :class="(status == 'paid')?'active':'u-pointer'" 
		@click="statusInput('paid')">
		<a>Paid</a>
	</li>
	<li class="hidden-xxxs" :class="(status == 'completed')?'active':'u-pointer'" 
		@click="statusInput('completed')">
		<a>Completed</a>
	</li>
	<li :class="(status == 'cancelled')?'active':'u-pointer'" 
		@click="statusInput('cancelled')">
		<a>Cancelled</a>
	</li>
</ul>
</template>

<script>
module.exports = {
	methods: {
		statusInput(status) {
			this.changePage(0)
			this.setStatus(status)
			this.$dispatch('GET')
		}
	},

	vuex: {
		getters: {
			status: state => state.invoices.status
		},

		actions: require(`../vuex/actions/dataTables.js`)
	}
}
</script>