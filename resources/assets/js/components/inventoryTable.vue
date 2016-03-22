<template>
	<div class='box box-warning'>
		<div class='box-header'>
			<h3 class='box-title'>
				<status-icon icon="fa-database" v-ref:status></status-icon> Inventory 
				<small>({{ itemCollection.length }} items found)</small>
			</h3>

			<div class="box-tools">
				<div class="input-group input-group-sm" style="width: 250px;">
					<input type="text" name="table_search" class="form-control pull-right" placeholder="Search" 
						:value="query" 
						@input="search | debounce 200">

					<div class="input-group-btn">
						<button type="submit" class="btn btn-default" @click="getItems"><i class="fa fa-search"></i></button>
					</div>
				</div>
			</div>
		</div>

		<div class="box-body no-padding">
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th style="width: 10px">ID#</th>
						<th>Name</th>
						<th>Stock</th>
						<th>Price</th>
						<th style="width: 150px">Updated</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="item in itemCollection.body" v-link="{ path: '/item/'+item.id }">
						<td>{{ item.id }}</td>
						<td>{{ item.name }}</td>
						<td>{{ item.stock }}</td>
						<td v-if="item.price_high == item.price_low">
							{{ item.price_high / 100 | currency }}
						</td>
						<td v-else>
							{{ item.price_low / 100 | currency }} - {{ item.price_high / 100 | currency }}
						</td>
						<td>{{ item.updated_at }}</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="box-footer">
			<pagination></pagination>
			<!-- <a href="#!/item/new" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add New Item</a> -->
		</div>
	</div>
</template>

<script>
module.exports = {
	data () {
		return {
			itemCollection: []
		}
	},

	ready () {
		this.getItems()
	},

	components: {
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue')
	},

	methods: {
		getItems () {
			this.$refs.status.working()
			var request = {
				_query: this.query
			}

			this.$http.get('items', request).then(function(response) {
				this.$refs.status.check()
				this.itemCollection = response.data
			})
		},

		search (e) {
			this.updateQuery(e.target.value)
			this.getItems()
		}
	},

	vuex: {
		getters: {
			query: state => state.inventory.query,
			sort: state => state.inventory.sort,
			ascending: state => state.inventory.ascending,
			page: state => state.inventory.page,
			limit: state => state.inventory.limit
		},

		actions: require('../vuex/actions/inventory.js')
	}
}
</script>