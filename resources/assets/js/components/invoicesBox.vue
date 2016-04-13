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

			<invoices-table :invoices="invoicesCollection.body"></invoices-table>
		</div>

		<div class="box-footer">
			<pagination :pages="invoicesCollection.pages" :page="page" class="pull-left"></pagination>

			<limit-selector class="pull-right"></limit-selector>
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
		invoicesTable: require('./invoicesTable.vue'),
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		limitSelector: require('./limitSelector.vue')
	},

	events: {
		GET () {
			this.expandIndex(-1)
			this.getInvoices()
		},

		CHANGE_PAGE (page) {
			this.changePage(page)
			this.getInvoices()
		},

		REFRESH () {
			this.expandIndex(-1)
			this.getInvoices()
		}
	},

	methods: {
		getInvoices () {
			this.$refs.status.working()

			this.$http.get('invoices', this.request).then(response => {
				this.$refs.status.check()
				this.invoicesCollection = response.data
			}, () => {
				this.$refs.status.fail()
			})
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
			expandedIndex: state => state.invoices.expandedIndex,
			status: state => state.invoices.status,
			request: state => state.invoices.request
		},

		actions: require('../vuex/actions/invoices.js')
	}
}
</script>