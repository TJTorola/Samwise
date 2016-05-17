<template>
<table class='table'>
	<thead>
		<th width="65"></th>
		<th width="1%">Name</th>
		<th style="min-width: 100px;"></th>
		<th width="100" class="text-right">Price</th>
		<th width="10"></th>
		<th width="40">Per.</th>
		<th width="80">Stock</th>
		<th width="20"></th>
		<th width="80">Reserve</th>
		<th width="65" v-if="offer.items.length > 1"></th>
	</thead>
	<tbody is="row" 
		v-for="item in offer.items" 
		:item="item"
		:index="$index"
		:offer="offer"
		:expanded-index.sync="expandedIndex">
	</tbody>
</table>
</template>

<script>
module.exports = {
	props: ['offer', 'expandedIndex'],

	components: {
		row: require('./row.vue')
	}
}
</script>