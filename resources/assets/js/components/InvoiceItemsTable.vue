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
			<span class="input-group-addon">
				<status-icon icon="fa-dollar" v-ref:shipping-cost></status-icon>
			</span>
			<input class="form-control input-sm text-right"
				:mask-value="cart.shipping_cost"
				:mask-input="shippingCostInput | debounce 500"
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
	props: ['cart', 'id'],

	components: {
		statusIcon: require('./statusIcon.vue')
	},
	
	methods: {
		shippingCostInput (cost) {
			this.$refs.shippingCost.working()
			cost = parseInt(parseFloat(cost.split(',').join('')) * 100)
			
			this.$http.patch(`/api/invoice/${this.id}`, { shipping_cost: cost }).then(response => {
				this.cart.due -= this.cart.shipping_cost
				this.cart.shipping_cost = cost
				this.cart.due += this.cart.shipping_cost
				this.$refs.shippingCost.check()
			}, () => {
				this.$refs.shippingCost.fail()
			})
		}
	}
}
</script>