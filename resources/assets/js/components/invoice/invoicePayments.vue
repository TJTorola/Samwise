<template>
<table class="table">
	<thead>
		<tr>
			<th>Card</th>
			<th>Charged On</th>
			<th>Amount</th>
		</tr>
	</thead>
	<tbody>
		<tr v-for="payment in payments">
			<td>{{ payment.card_brand }} '{{ payment.last_four | frontZeros 4 }}'</td>
			<td>{{ payment.charged }}</td>
			<td>{{ payment.amount / 100 | currency }}</td>
		</tr>
	</tbody>
	<tfoot>
		<tr> <!-- paid -->
			<th class="text-right" colspan="2">Total Paid:</th>
			<td>
				{{ cart.paid / 100 | currency }}
			</td>
		</tr>

		<tr>
			<th class="text-right" colspan="2">Due:</th>
			<td>
				{{ cart.due / 100 | currency }}
			</td>
		</tr>
	</tfoot>
</table>
</template>

<script>
const frontZeros = (targetLength, string) => {
	if (string.length === targetLength) return string;
	return frontZeros(targetLength, `0${string}`);
}

module.exports = {
	props: ['cart', 'payments'],

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	}
}
</script>