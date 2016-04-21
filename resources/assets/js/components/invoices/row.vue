<template>
<tr>
	<td>{{ invoice.id }}</td>
	<td><a v-link="{ path: '/invoice/'+invoice.id }">{{ invoice.last_name }}, {{ invoice.first_name }}</a></td>
	<td class="text-right hidden-xxxs">{{ invoice.subtotal / 100 | currency }}</td>
	<td class="text-center hidden-xxxs">
		<status-toggle mode="billed" 
			:state="invoice.billed"
			:id="invoice.id"></status-toggle>
		<status-toggle mode="paid" 
			:state="invoice.paid"
			:id="invoice.id"></status-toggle>
		<status-toggle mode="shipped" 
			:state="invoice.shipped"
			:id="invoice.id"></status-toggle>
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
		statusToggle: require('./statusToggle.vue')
	},

	vuex: {
		getters: {
			expandedIndex: state => state.invoices.expandedIndex
		},

		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>