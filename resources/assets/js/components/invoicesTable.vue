<template>
	<table class="table table-hover">
		<thead class="u-unselectable">
			<tr>
				<th class="u-active" style="width: 50px" @click="sortInput('id')">
					ID <sort-icon key="id"></sort-icon>
				</th>
				<th class="u-active" @click="sortInput('name')">
					Name <sort-icon key="name"></sort-icon>
				</th>
				<th class="u-active text-right hidden-xxxs" style="width: 95px" @click="sortInput('subtotal')">
					<sort-icon key="subtotal"></sort-icon> Subtotal
				</th>
				<th class="text-center hidden-xxxs" style="width: 75px">Status</th>
				<th style="width: 60px" class="hidden-xxs"></th>
			</tr>
		</thead>

		<tbody v-for="invoice in invoices">
			<tr>
				<td>{{ invoice.id }}</td>
				<td><a v-link="{ path: '/invoice/'+invoice.id }">{{ invoice.last_name }}, {{ invoice.first_name }}</a></td>
				<td class="text-right hidden-xxxs">{{ invoice.subtotal / 100 | currency }}</td>
				<td class="text-center hidden-xxxs">
					<i class="fa fa-file-text u-active" 
						@click="toggleStatus(invoice.id, 'billed')"
						:class="invoice.billed?'u-green':'u-gray'"></i>
					<i class="fa fa-credit-card u-active" 
						@click="toggleStatus(invoice.id, 'paid')"
						:class="invoice.paid?'u-green':'u-gray'"></i>
					<i class="fa fa-truck u-active" 
						@click="toggleStatus(invoice.id, 'shipped')"
						:class="invoice.shipped?'u-green':'u-gray'"></i>
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
</template>

<script>
module.exports = {
	props: ['invoices'],

	components: {
		sortIcon: require('./sortIcon.vue'),
		invoiceSummary: require('./invoiceSummary.vue')
	},

	methods: {
		sortInput(key) {
			this.setSort('invoices', key)
			this.$dispatch('GET')
		},

		findInvoiceById(id) {
			for (var i = 0; i < this.invoicesCollection.body.length; i++) {
				if (this.invoicesCollection.body[i]['id'] == id) {
					return this.invoicesCollection.body[i]
				}
			}

			return null
		},

		toggleStatus (id, status) {
			this.$refs.status.working()

			var invoice = this.findInvoiceById(id)
			if (invoice == null) {
				this.$refs.status.fail()
				return null
			}

			if (status == 'billed') {
				var request = {
					billed: !invoice.billed
				}
			} else if (status == 'paid') {
				var request = {
					paid: !invoice.paid
				}
			} else if (status == 'shipped') {
				var request = {
					shipped: !invoice.shipped
				}
			} else {
				this.$refs.status.fail()
				return null
			}

			this.$http.patch(`invoice/${id}`, request).then(response => {
				this.getInvoices()
			}, () => {
				this.$refs.status.fail()
			})
		},

		vuex: {
			actions: require(`../vuex/actions/dataTables.js`)
		}
	}
}
</script>