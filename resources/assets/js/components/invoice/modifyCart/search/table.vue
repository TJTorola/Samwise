<template>
<table class="table" v-if="results.length > 0">
	<thead>
		<tr>
			<th style="width:60px;"></th>
			<th>Item</th>
			<th>Stock</th>
			<th>Price</th>
		</tr>
	</thead>
	<tbody>
		<tr is="row" :result="result" v-for="result in results" :cart="cart"></tr>
	</tbody>
</table>
</template>

<script>
module.exports = {
	props: ['results', 'cart'],

	components: {
		row: require('./row.vue')
	}
}
</script>