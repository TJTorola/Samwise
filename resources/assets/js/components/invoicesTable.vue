<template>
	<div class='box box-success'>
		<div class='box-header'>
			<h3 class='box-title'>
				<status-icon icon="fa-credit-card" v-ref:status></status-icon> <span class="hidden-xxs">Invoice Table</span>
				<small class="hidden-xs">({{ invoicesCollection.length }} Invoices found)</small>
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
			<ul class="nav nav-tabs">
				<li :class="(status == 'all')?'active':'u-pointer'" 
					@click="statusAndGet('all')" style="margin-left: 10px;">
					<a>All</a>
				</li>
				<li :class="(status == 'active')?'active':'u-pointer'" 
					@click="statusAndGet('active')">
					<a>Active</a>
				</li>
				<li class="hidden-xs" :class="(status == 'new')?'active':'u-pointer'" 
					@click="statusAndGet('new')">
					<a>New</a>
				</li>
				<li class="hidden-xs" :class="(status == 'billed')?'active':'u-pointer'" 
					@click="statusAndGet('billed')">
					<a>Billed</a>
				</li>
				<li class="hidden-xs" :class="(status == 'paid')?'active':'u-pointer'" 
					@click="statusAndGet('paid')">
					<a>Paid</a>
				</li>
				<li class="hidden-xxxs" :class="(status == 'completed')?'active':'u-pointer'" 
					@click="statusAndGet('completed')">
					<a>Completed</a>
				</li>
				<li :class="(status == 'cancelled')?'active':'u-pointer'" 
					@click="statusAndGet('cancelled')">
					<a>Cancelled</a>
				</li>
			</ul>

			<table class="table table-hover">
				<thead class="u-unselectable">
					<tr>
						<th class="u-active" style="width: 50px" @click="sortAndGet('id')">
							ID <sort-icon key="id"></sort-icon>
						</th>
						<th class="u-active" @click="sortAndGet('name')">
							Name <sort-icon key="name"></sort-icon>
						</th>
						<th class="u-active text-right hidden-xxxs" style="width: 95px" @click="sortAndGet('subtotal')">
							<sort-icon key="subtotal"></sort-icon> Subtotal
						</th>
						<th class="text-center hidden-xxxs" style="width: 75px">Status</th>
						<th style="width: 60px" class="hidden-xxs"></th>
					</tr>
				</thead>
				<tbody v-for="invoice in invoicesCollection.body">
					<tr>
						<td>{{ invoice.id }}</td>
						<td><a v-link="{ path: '/invoice/'+invoice.id }">{{ invoice.last_name }}, {{ invoice.first_name }}</a></td>
						<td class="text-right hidden-xxxs">{{ invoice.subtotal / 100 | currency }}</td>
						<td class="text-center hidden-xxxs">
							<i class="fa fa-file-text u-active" :class="invoice.billed?'u-green':'u-gray'"></i>
							<i class="fa fa-credit-card u-active" :class="invoice.paid?'u-green':'u-gray'"></i>
							<i class="fa fa-truck u-active" :class="invoice.shipped?'u-green':'u-gray'"></i>
						</td>
						<td class="hidden-xxs">
							<button type="button" class="btn btn-block btn-xs u-no-margin" 
								@click="(expandedIndex != invoice.id)?expandIndex(invoice.id):expandIndex(-1)">
								<i class="fa fa-plus" v-if="expandedIndex != invoice.id"></i>
								<i class="fa fa-minus" v-else></i> <i class="fa fa-search"></i>
							</button>
						</td>
					</tr>
					<tr v-if="expandedIndex == invoice.id" class="hidden-xxs" style="background: white;">
						<td colspan="7">
							<invoice-summary :invoice="invoice"></invoice-summary>

							<div class="row">
								<div class="col-xs-6 col-xs-offset-3">
									<button type="button" class="btn btn-block btn-sm btn-primary">
										View/Edit Full Invoice <i class="fa fa-search"></i>
									</button>
								</div>
							</div>
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="box-footer">
			<pagination :pages="invoicesCollection.pages" :page="page" class="pull-left"></pagination>

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
			invoicesCollection: {
				pages: 1
			},

			searchValue: "",

			loaded: false
		}
	},

	ready () {
		this.getInvoices()
	},

	components: {
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		sortIcon: require('./sortIcon.vue'),
		invoiceSummary: require('./invoiceSummary.vue')
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

		must () {
			if (this.status == 'active' || this.status == 'all') {
				var must = {}
			} else {
				var must = {
					status: this.status
				}
			}

			return JSON.stringify(must)
		},

		mustNot () {
			if (this.status == 'active') {
				var mustNot = {
					status: 'completed'
				}
			} else {
				var mustNot = {}
			}

			return JSON.stringify(mustNot)
		},

		request () {
			return {
				_query: this.query,
				_page: this.page,
				_limit: this.limit,
				_sort: this.sortQuery,
				_must: this.must,
				_must_not: this.mustNot
			}
		}
	},

	events: {
		CHANGE_PAGE (page) {
			this.changePage(page)
			this.getInvoices()
		}
	},

	methods: {
		getInvoices () {
			this.$refs.status.working()

			this.$http.get('invoices', this.request).then(function(response) {
				this.$refs.status.check()
				this.invoicesCollection = response.data
			})
		},

		sortArray (sort) {
			if (sort.key == 'name') {
				if (sort.ascending) {
					var sortArray = {
						'last_name': 'asc',
						'first_name': 'asc'
					}
				} else {
					var sortArray = {
						'last_name': 'desc',
						'first_name': 'desc'
					}
				}

				return sortArray
			}
			
			if (sort.ascending) {
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
			this.getInvoices()
		},

		clearSearch () {
			this.changePage(0)
			this.updateQuery('')
			this.getInvoices()
		},

		sortAndGet (key) {
			this.setSort(key)
			this.getInvoices()
		},

		limitAndGet (e) {
			this.setLimit(e.target.value)
			this.getInvoices()
		},

		statusAndGet (status) {
			this.changePage(0)
			this.setStatus(status)
			this.getInvoices()
		}
	},

	vuex: {
		getters: {
			query: state => state.invoices.query,
			sort: state => state.invoices.sort,
			sortSecond: state => state.invoices.sortSecond,
			ascending: state => state.invoices.ascending,
			page: state => state.invoices.page,
			limit: state => state.invoices.limit,
			expandedIndex: state => state.invoices.expandedIndex,
			status: state => state.invoices.status
		},

		actions: require('../vuex/actions/invoices.js')
	}
}
</script>