<template>
<table class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Unit Cost</th>
			<th>Count</th>
		</tr>
	</thead>
	<tbody>
	<tr v-for="item in cart.items">
		<td>{{{ item.name | nl2br }}}</td>
		<td>{{ item.price / 100 | currency }}</td>
			<td>{{ item.count }}</td>
	</tr>

	<tr> <!-- subtotal -->
		<td class="text-right">
			<b>Subtotal:</b>
		</td>
		<td colspan="2">{{ cart.subtotal / 100 | currency }}</td>
	</tr>

	<tr> <!-- shipping -->
		<td class="text-right">
			<b>Shipping:</b>
		</td>

		<td colspan="2">
			<div class="input-group input-group-sm">
			<span class="input-group-addon"><i class="fa fa-dollar" id="shipping-cost-status"></i></span>
			<input class="form-control input-sm text-right"
				v-mask:rtl="#,###,###.##"
				hint=".00">
		</div>
		</td>
	</tr>

	<tr> <!-- paid -->
		<td class="text-right">
			<b>Paid:</b>
		</td>

		<td colspan="2">
			{{ cart.paid / 100 | currency }}
		</td>
	</tr>
	</tbody>
	<tfoot>
		<tr>
			<th class="text-right">Due:</th>
			<td colspan="2">{{ cart.due / 100 | currency }}</td>
		</tr>
	</tfoot>
</table>
</template>

<script>
module.exports = {
	props: ['cart'],
	
	methods: {
		test () {
			console.log('hi')
			return 1
		}
	}
}
</script>