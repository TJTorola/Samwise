<template>
<tr>
	<td>{{ invoice.id }}</td>
	<td><a v-link="{ path: '/invoice/'+invoice.id }">{{ invoice.last_name }}, {{ invoice.first_name }}</a></td>
	<td class="text-right hidden-xxxs">{{ invoice.subtotal / 100 | currency }}</td>
	<td class="text-center hidden-xxxs">
		<invoice-status mode="billed" 
			:state="invoice.billed"
			:id="invoice.id"></invoice-status>
		<invoice-status mode="paid" 
			:state="invoice.paid"
			:id="invoice.id"></invoice-status>
		<invoice-status mode="shipped" 
			:state="invoice.shipped"
			:id="invoice.id"></invoice-status>
	</td>
	<td class="hidden-xxs">
		<button type="button" class="btn btn-block btn-xs u-no-margin" 
			@click="(expandedIndex != invoice.id)?expandIndex('invoices', invoice.id):expandIndex('invoices', -1)">
			<i class="fa fa-plus" v-if="expandedIndex != invoice.id"></i>
			<i class="fa fa-minus" v-else></i> <i class="fa fa-search"></i>
		</button>
	</td>
</tr>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		invoiceStatus: require('./invoiceStatus.vue')
	},

	vuex: {
		getters: {
			expandedIndex: state => state.invoices.expandedIndex
		},

		actions: require(`../vuex/actions/dataTables.js`)
	}
}
</script>