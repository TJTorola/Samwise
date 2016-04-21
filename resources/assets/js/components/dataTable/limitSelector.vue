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
	props: ['mode'],

	computed: {
		limit() {
			if (this.mode == 'offers') {
				return this.offersLimit
			} else if (this.mode == 'invoices') {
				return this.invoicesLimit
			}
		}
	},

	methods: {
		limitInput (e) {
			this.setLimit(this.mode, e.target.value)
			this.$dispatch('GET')
		}
	},

	vuex: {
		getters: {
			invoicesLimit: state => state.invoices.limit,
			offersLimit: state => state.offers.limit
		},

		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>