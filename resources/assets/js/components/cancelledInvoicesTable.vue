<template>
	<table class="table table-hover">
		<thead class="u-unselectable">
			<tr>
				<th style="width: 50px">ID</th>
				<th>Name</th>
				<th class="text-right hidden-xxxs" style="width: 95px">Subtotal</th>
				<th style="width: 60px"></th>
				<th style="width: 60px"></th>
			</tr>
		</thead>

		<tbody v-for="invoice in invoices">
			<tr is="invoice-row" :invoice="invoice"></tr>
		</tbody>
	</table>
</template>

<script>
module.exports = {
	props: ['invoices'],

	components: {
		invoiceRow: require('./cancelledInvoiceRow.vue'),
		invoiceSorters: require('./cancelledInvoiceSorters.vue'),
	}
}
</script>