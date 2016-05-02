<template>
<tr>
	<td>
		<add-to-cart :cart="cart" :item="result"></add-to-cart>
	</td>
	<td>{{ result.full_name }}</td> <!-- Name -->
	<td>
		<span v-if='result.infinite'>∞</span>
		<span v-else>{{ result.stock }}</span>
	</td> <!-- Stock -->
	<td>{{ result.price / 100 | currency }}</td> <!-- Price -->
</tr>
</template>

<script>
module.exports = {
	props: ['result', 'cart'],

	components: {
		addToCart: require('./addToCart.vue')
	}
}
</script>