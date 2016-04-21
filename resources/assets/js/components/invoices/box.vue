<template>
<div class='box box-success'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-credit-card" v-ref:status></status-icon> <span class="hidden-xxs">Invoice Table</span>
			<small class="hidden-xs">({{ invoicesCollection.length }} Invoices found)</small>
		</h3>

		<div class="box-tools">
			<query-input mode="invoices" v-if="status != 'cancelled'"></query-input>
		</div>
	</div>

	<div class="box-body no-padding">
		<invoice-tabs></invoice-tabs>

		<cancelled-invoices-table v-if="status == 'cancelled'"
			:invoices="invoicesCollection.body"></cancelled-invoices-table>
		<invoices-table :invoices="invoicesCollection.body" v-else></invoices-table>
	</div>

	<div class="box-footer">
		<pagination :pages="invoicesCollection.pages" mode="invoices" class="pull-left"></pagination>

		<limit-selector class="pull-right" mode="invoices"></limit-selector>
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
			loaded: false
		}
	},

	ready () {
		this.getInvoices()
	},

	components: {
		invoicesTable: require('./table.vue'),
		invoiceTabs: require('./tabs.vue'),
		cancelledInvoicesTable: require('./cancelled/table.vue'),
		statusIcon: require('app/components/statusIcon.vue'),
		pagination: require('app/components/dataTable/pagination.vue'),
		limitSelector: require('app/components/dataTable/limitSelector.vue'),
		queryInput: require('app/components/dataTable/queryInput.vue')
	},

	events: {
		GET () {
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

			var route = (this.status == 'cancelled') ? 'cancelled-invoices' : 'invoices'
			this.$http.get(route, this.request).then(response => {
				this.$refs.status.check()
				this.invoicesCollection = response.data
			}, () => {
				this.$refs.status.fail()
			})
		}
	},

	vuex: {
		getters: {
			request: state => state.invoices.request,
			status: state => state.invoices.status
		},

		actions: require('app/vuex/actions/dataTables.js')
	}
}
</script>