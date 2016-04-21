<template>
<div class="input-group input-group-sm" style="width: 250px;">
	<input type="text" name="table_search" class="form-control pull-right" placeholder="Search" 
		:value="query" 
		@input="search | debounce 200"
		v-model="searchInput">

	<div class="input-group-btn">
		<button type="submit" class="btn btn-default" @click="clear">
			<i class="fa fa-times" v-if="searchInput"></i>
			<i class="fa fa-search" v-else></i>
		</button>
	</div>
</div>
</template>

<script>
module.exports = {
	data() {
		return {
			searchInput: ''
		}
	},

	props: ['mode'],

	computed: {
		query () {
			if (this.mode == 'offers') {
				return this.offersQuery
			} else if (this.mode == 'invoices') {
				return this.invoicesQuery
			}
		}
	},

	methods: {
		search() {
			this.changePage(this.mode, 0)
			this.updateQuery(this.mode, this.searchInput)
			this.$dispatch('GET')
		},

		clear() {
			this.searchInput = ''
			this.search()
		}
	},

	vuex: {
		getters: {
			invoicesQuery: state => state.invoices.query,
			offersQuery: state => state.offers.query
		},

		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>