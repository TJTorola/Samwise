<template>
<table class="table">
	<thead>
		<tr>
			<th>Card</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<tr v-for="payment in payments">
			<td>{{ payment.card_brand }} '{{ payment.last_four }}'</td>
			<td>{{ payment.amount / 100 | currency }}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr> <!-- paid -->
			<th class="text-right">Total Paid:</th>
			<td>
				{{ cart.paid / 100 | currency }}
			</td>
		</tr>

		<tr>
			<th class="text-right">Due:</th>
			<td>
				{{ cart.due / 100 | currency }}
			</td>
		</tr>
	</tfoot>
</table>
</template>

<script>
module.exports = {
	props: ['cart', 'payments'],

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	}
}
</script>