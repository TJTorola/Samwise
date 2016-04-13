<template>
<span class="form-inline">
	Show
	<select class="form-control input-sm" :value="limit" @change="limitInput">
		<option value="10">10</option>
		<option value="25">25</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select> 
	entries
</span>
</template>

<script>
module.exports = {
	methods: {
		limitInput (e) {
			this.setLimit(e.target.value)
			this.$dispatch('GET')
		}
	},

	vuex: {
		getters: {
			limit: state => state.invoices.limit
		},

		actions: require('../vuex/actions/invoices.js')
	}
}
</script>