<template>
	<div class='box box-success'>
		<div class='box-header'>
			<h3 class='box-title'>
				<status-icon icon="fa-credit-card" v-ref:status></status-icon> Invoice Table
				<small>({{ invoicesCollection.length }} Invoices found)</small>
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
				<li class="active" style="margin-left: 10px;"><a>Active</a></li>
				<li><a>New</a></li>
				<li><a>Billed</a></li>
				<li><a>Paid</a></li>
				<li><a>Shipped</a></li>
				<li><a>Cancelled</a></li>
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
						<th class="u-active" style="width: 150px" @click="sortAndGet('created_at')">
							Created <sort-icon key="created_at"></sort-icon>
						</th>
						<th style="width: 75px">Status</th>
						<th style="width: 60px"></th>
					</tr>
				</thead>
				<tbody v-for="invoice in invoicesCollection.body">
					<tr>
						<td>{{ invoice.id }}</td>
						<td>{{ invoice.last_name }}, {{ invoice.first_name }}</td>
						<td>{{ invoice.created_at }}</td>
						<td>
							<i class="fa fa-file-text"></i>
							<i class="fa fa-credit-card"></i>
							<i class="fa fa-truck"></i>
						</td>
						<td>
							<button type="button" class="btn btn-block btn-xs u-no-margin" 
								@click="(expandedIndex != invoice.id)?expandIndex(invoice.id):expandIndex(-1)">
								<i class="fa fa-plus" v-if="expandedIndex != invoice.id"></i>
								<i class="fa fa-minus" v-else></i>
							</button>
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
		sortIcon: require('./sortIcon.vue')
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

			this.$http.get('invoices', request).then(function(response) {
				this.$refs.status.check()
				this.invoicesCollection = response.data
			})
		},

		sortToArray (sort) {
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
			expandedIndex: state => state.invoices.expandedIndex
		},

		actions: require('../vuex/actions/invoices.js')
	}
}
</script>