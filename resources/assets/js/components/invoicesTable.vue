<template>
	<table class="table table-hover">
		<thead is="invoice-sorters"></thead>

		<tbody v-for="invoice in invoices">
			<tr is="invoice-row" :invoice="invoice"></tr>
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
		invoiceSummary: require('./invoiceSummary.vue'),
		invoiceSorters: require('./invoiceSorters.vue'),
		invoiceRow: require('./invoiceRow.vue')
	},

	vuex: {
		
	}
}
</script>