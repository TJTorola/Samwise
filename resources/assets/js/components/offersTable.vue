<template>
	<div class='box box-warning'>
		<div class='box-header'>
			<h3 class='box-title'>
				<status-icon icon="fa-archive" v-ref:status></status-icon> <span class="hidden-xxs">Offers Table</span>
				<small class="hidden-xs">({{ offersCollection.length }} Offers found)</small>
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
						<th class="u-active" style="width: 50px" @click="sortAndGet('id')">
							ID <sort-icon key="id"></sort-icon>
						</th>
						<th class="u-active" @click="sortAndGet('name')">
							Name <sort-icon key="name"></sort-icon>
						</th>
						<th class="u-active text-right" @click="sortAndGet('price')">
							<sort-icon key="price"></sort-icon> Price
						</th>
						<th class="u-active text-right" style="width: 75px;" @click="sortAndGet('sold')">
							<sort-icon key="sold"></sort-icon> Sold
						</th>
						<th class="u-active text-right" style="width: 75px;" @click="sortAndGet('stock')">
							<sort-icon key="stock"></sort-icon> Stock
						</th>
						<th style="width: 60px"></th>
					</tr>
				</thead>
				<tbody v-for="offer in offersCollection.body">
					<tr>
						<td>{{ offer.id }}</td>
						<td>
							<a v-link="{ path: '/offer/'+offer.id }">{{ offer.name }}</a>
						</td>
						<td class="text-right" v-if="offer.price_high == offer.price_low">
							{{ offer.price_high / 100 | currency }}
						</td>
						<td class="text-right" v-else>
							{{ offer.price_low / 100 | currency }} - {{ offer.price_high / 100 | currency }}
						</td>
						<td class="text-right">{{ offer.sold }}</td>
						<td class="text-right" v-if="offer.infinite">∞</td>
						<td class="text-right" v-else>{{ offer.stock }}</td>
						<td v-if="offer.items.length == 1">
							<add-to-cart :id="offer.items[0].id"></add-to-cart>
						</td>
						<td v-else>
							<button type="button" class="btn btn-block btn-xs u-no-margin" 
								@click="(expandedIndex != offer.id)?expandIndex(offer.id):expandIndex(-1)">
								<i class="fa fa-plus" v-if="expandedIndex != offer.id"></i>
								<i class="fa fa-minus" v-else></i>
							</button>
						</td>
					</tr>
					<tr v-if="expandedIndex == offer.id" v-for="item in offer.items" style="background: #F7F7F7;">
						<td></td>
						<td> - {{ item.name }}</td>
						<td class="text-right">{{ item.price / 100 | currency }}</td>
						<td class="text-right">{{ item.sold }}</td>
						<td class="text-right" v-if="item.infinite">∞</td>
						<td class="text-right" v-else>{{ item.stock }}</td>
						<td>
							<add-to-cart :id="item.id"></add-to-cart>
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="box-footer">
			<pagination :pages="offersCollection.pages" :page="page" class="pull-left"></pagination>

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
		</div>
	</div>
</template>

<script>
module.exports = {
	data () {
		return {
			offersCollection: {
				pages: 1
			},

			searchValue: "",

			loaded: false
		}
	},

	ready () {
		this.getOffers()
	},

	components: {
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		sortIcon: require('./sortIcon.vue'),
		addToCart: require('./addToCart.vue')
	},

	computed: {
		sortQuery () {
			if (this.sortSecond) {
				var sort = Object.assign(
					this.sortArray(this.sort),
					this.sortArray(this.sortSecond)
				)
			} else {
				var sort = this.sortArray(this.sort)
			}

			return JSON.stringify(sort)
		},

		request () {
			return {
				_query: this.query,
				_page: this.page,
				_limit: this.limit,
				_sort: this.sortQuery
			}
		}
	},

	events: {
		CHANGE_PAGE (page) {
			this.changePage(page)
			this.getOffers()
		}
	},

	methods: {
		getOffers () {
			this.$refs.status.working()

			this.$http.get('offers', this.request).then(function(response) {
				console.log()
				this.$refs.status.check()
				this.offersCollection = response.data
			})
		},

		sortArray (sort) {
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
			this.getOffers()
		},

		clearSearch () {
			this.changePage(0)
			this.updateQuery('')
			this.getOffers()
		},

		sortAndGet (key) {
			this.setSort(key)
			this.getOffers()
		},

		limitAndGet (e) {
			this.setLimit(e.target.value)
			this.getOffers()
		}
	},

	vuex: {
		getters: {
			query: state => state.offers.query,
			sort: state => state.offers.sort,
			sortSecond: state => state.offers.sortSecond,
			ascending: state => state.offers.ascending,
			page: state => state.offers.page,
			limit: state => state.offers.limit,
			expandedIndex: state => state.offers.expandedIndex,
			status: state => state.offers.status
		},

		actions: require('../vuex/actions/offers.js')
	}
}
</script>