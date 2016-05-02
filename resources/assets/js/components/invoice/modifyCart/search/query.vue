<template>
<div>
	<h4>Add New Stocked Item</h4>
	<hr>

	<div class="input-group input-group-sm">
		<span class="input-group-addon">
			<status-icon icon="fa-search" v-ref:search></status-icon>
		</span>
		<input type="text" class="form-control" placeholder="Search Inventory..." 
			@input="searchInventory | debounce"
			v-model="query">
	</div>

	<results-table :results="results" :cart="cart"></results-table>
</div>
</template>

<script>
module.exports = {
	data() {
		return {
			query: '',
			results: []
		}
	},

	props: ['cart'],

	components: {
		statusIcon: require('app/components/statusIcon.vue'),
		resultsTable: require('./table.vue')
	},

	watch: {
		query () {
			this.$refs.search.working()
		}
	},

	methods: {
		searchInventory () {
			if (this.query == '') {
				this.$set('results', [])
				this.$refs.search.check()
				return
			}

			var query = {
				_query: this.query
			}

			this.$http.get('items', query).then(response => {
				this.$refs.search.check()
				this.$set('results', response.data.body)
			}, () => {
				this.$refs.search.fail()
			})
		}
	}
}
</script>