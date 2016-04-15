<template>
<div class='box box-warning'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-archive" v-ref:status></status-icon> <span class="hidden-xxs">Offers Table</span>
			<small class="hidden-xs">({{ offersCollection.length }} Offers found)</small>
		</h3>

		<div class="box-tools">
			<table-query mode="offers"></table-query>
		</div>
	</div>

	<div class="box-body no-padding">
		<offers-table :offers="offersCollection.body"></offers-table>
	</div>

	<div class="box-footer">
		<pagination :pages="offersCollection.pages" mode="offers" class="pull-left"></pagination>

		<limit-selector class="pull-right" mode="offers"></limit-selector>
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
		offersTable: require('./offersTable.vue'),
		statusIcon: require('./statusIcon.vue'),
		pagination: require('./pagination.vue'),
		limitSelector: require('./limitSelector.vue'),
		tableQuery: require('./tableQuery.vue')
	},

	events: {
		GET () {
			this.getOffers()
		},

		REFRESH () {
			this.expandIndex(-1)
			this.getOffers()
		}
	},

	methods: {
		getOffers () {
			this.$refs.status.working()

			this.$http.get('offers', this.request).then(response => {
				this.$refs.status.check()
				this.offersCollection = response.data
			}, () => {
				this.$refs.status.fail()
			})
		}
	},

	vuex: {
		getters: {
			request: state => state.offers.request,
			status: state => state.offers.status
		},

		actions: require('../vuex/actions/dataTables.js')
	}
}
</script>