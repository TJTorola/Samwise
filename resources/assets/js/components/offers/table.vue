<template>
<table class="table table-hover">
	<thead is="sorters"></thead>

	<tbody is="row" 
		v-for="offer in offers"
		:offer="offer" ></tbody>
</table>
</template>

<script>
// offers/table.vue
module.exports = {
	props: ['offers'],

	components: {
		row: require('./row.vue'),
		sorters: require('./sorters.vue')
	}
}
</script>