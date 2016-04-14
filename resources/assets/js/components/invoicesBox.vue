<template>
<div class='box box-success'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-credit-card" v-ref:status></status-icon> <span class="hidden-xxs">Invoice Table</span>
			<small class="hidden-xs">({{ invoicesCollection.length }} Invoices found)</small>
		</h3>

		<div class="box-tools">
			<table-query mode="invoices"></table-query>
		</div>
	</div>

	<div class="box-body no-padding">
		<invoice-tabs></invoice-tabs>

		<invoices-table :invoices="invoicesCollection.body"></invoices-table>
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
		invoicesTable: require('./invoicesTable.vue'),
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		limitSelector: require('./limitSelector.vue'),
		tableQuery: require('./tableQuery.vue'),
		invoiceTabs: require('./invoiceTabs.vue')
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

			this.$http.get('invoices', this.request).then(response => {
				this.$refs.status.check()
				this.invoicesCollection = response.data
			}, () => {
				this.$refs.status.fail()
			})
		}
	},

	vuex: {
		getters: {
			request: state => state.invoices.request
		}
	}
}
</script>