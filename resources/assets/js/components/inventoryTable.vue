<template>
	<div class='box box-warning'>
		<div class='box-header'>
			<h3 class='box-title'>
				<status-icon icon="fa-archive" v-ref:status></status-icon> Inventory Table
				<small>({{ itemCollection.length }} items found)</small>
			</h3>

			<div class="box-tools">
				<div class="input-group input-group-sm" style="width: 250px;">
					<input type="text" name="table_search" class="form-control pull-right" placeholder="Search" 
						:value="query" 
						@input="search | debounce 200"
						v-model="searchValue">

					<div class="input-group-btn">
						<button type="submit" class="btn btn-default" @click="clearSearch">
							<i class="fa fa-times" v-if="searchValue"></i>
							<i class="fa fa-search" v-else></i>
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="box-body no-padding">
			<table class="table table-hover">
				<thead class="u-unselectable">
					<tr>
						<th style="width: 50px" @click="sortAndGet('id')">
							ID <sort-icon key="id"></sort-icon>
						</th>
						<th @click="sortAndGet('name')">
							Name <sort-icon key="name"></sort-icon>
						</th>
						<th class="text-right" @click="sortAndGet('price')">
							<sort-icon key="price"></sort-icon> Price
						</th>
						<th class="text-right" style="width: 75px;" @click="sortAndGet('sold')">
							<sort-icon key="sold"></sort-icon> Sold
						</th>
						<th class="text-right" style="width: 75px;" @click="sortAndGet('stock')">
							<sort-icon key="stock"></sort-icon> Stock
						</th>
						<th style="width: 60px" class="text-right">
							Cart
						</th>
					</tr>
				</thead>
				<tbody v-for="item in itemCollection.body">
					<tr> <!--  -->
						<td>{{ item.id }}</td>
						<td>
							<a v-link="{ path: '/item/'+item.id }">{{ item.name }}</a>
						</td>
						<td class="text-right" v-if="item.price_high == item.price_low">
							{{ item.price_high / 100 | currency }}
						</td>
						<td class="text-right" v-else>
							{{ item.price_low / 100 | currency }} - {{ item.price_high / 100 | currency }}
						</td>
						<td class="text-right">{{ item.sold }}</td>
						<td class="text-right" v-if="item.infinite">∞</td>
						<td class="text-right" v-else>{{ item.stock }}</td>
						<td v-if="item.variants.length == 1">
							<button type="button" class="btn btn-block btn-warning btn-xs u-no-margin">0 <i class="fa fa-shopping-cart"></i></button>
						</td>
						<td v-else>
							<button type="button" class="btn btn-block btn-xs u-no-margin" 
								@click="(expandedIndex != item.id)?expandIndex(item.id):expandIndex(-1)">
								<i class="fa fa-plus" v-if="expandedIndex != item.id"></i>
								<i class="fa fa-minus" v-else></i>
							</button>
						</td>
					</tr>
					<tr v-if="expandedIndex == item.id" v-for="variant in item.variants" style="background: #F7F7F7;">
						<td></td>
						<td> - {{ variant.name }}</td>
						<td class="text-right">{{ variant.price / 100 | currency }}</td>
						<td class="text-right">{{ variant.sold }}</td>
						<td class="text-right" v-if="variant.infinite">∞</td>
						<td class="text-right" v-else>{{ variant.stock }}</td>
						<td>
							<button type="button" class="btn btn-block btn-warning btn-xs u-no-margin">0 <i class="fa fa-shopping-cart"></i></button>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="box-footer">
			<pagination :pages="itemCollection.pages" :page="page" class="pull-left"></pagination>

			<span class="form-inline pull-right">
				Show
				<select class="form-control input-sm" :value="limit" @change="limitAndGet">
					<option value="10">10</option>
					<option value="25">25</option>
					<option value="50">50</option>
					<option value="100">100</option>
				</select> 
				entries
			</span>
			<!-- <a href="#!/item/new" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add New Item</a> -->
		</div>
	</div>
</template>

<script>
module.exports = {
	data () {
		return {
			itemCollection: {
				pages: 1
			},

			searchValue: ""
		}
	},

	ready () {
		this.getItems()
	},

	components: {
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		sortIcon: require('./sortIcon.vue')
	},

	events: {
		CHANGE_PAGE (page) {
			this.changePage(page)
			this.getItems()
		}
	},

	methods: {
		getItems () {
			this.$refs.status.working()

			if (this.sortSecond) {
				var sort = Object.assign(
					this.sortToArray(this.sort),
					this.sortToArray(this.sortSecond)
				)
			} else {
				var sort = this.sortToArray(this.sort)
			}

			var request = {
				_query: this.query,
				_page: this.page,
				_limit: this.limit,
				_sort: JSON.stringify(sort)
			}

			this.$http.get('items', request).then(function(response) {
				this.$refs.status.check()
				this.itemCollection = response.data
			})
		},

		sortToArray (sort) {
			if (sort.key == 'price' && sort.ascending) {
				// price gets sorted by price_high or price_low keys
				var sortArray = {
					price_low: 'asc'
				}
			} else if (sort.key == 'price' && !sort.ascending) {
				var sortArray = {
					price_high: 'desc'
				}
			} else if (sort.ascending) {
				var sortArray = {}
				sortArray[sort.key] = 'asc'
			} else {
				var sortArray = {}
				sortArray[sort.key] = 'desc'
			}

			return sortArray
		},

		search () {
			this.changePage(0)
			this.updateQuery(this.searchValue)
			this.getItems()
		},

		clearSearch () {
			this.changePage(0)
			this.updateQuery('')
			this.getItems()
		},

		sortAndGet (key) {
			this.setSort(key)
			this.getItems()
		},

		limitAndGet (e) {
			this.setLimit(e.target.value)
			this.getItems()
		}
	},

	vuex: {
		getters: {
			query: state => state.inventory.query,
			sort: state => state.inventory.sort,
			sortSecond: state => state.inventory.sortSecond,
			ascending: state => state.inventory.ascending,
			page: state => state.inventory.page,
			limit: state => state.inventory.limit,
			expandedIndex: state => state.inventory.expandedIndex
		},

		actions: require('../vuex/actions/inventory.js')
	}
}
</script>