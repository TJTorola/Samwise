<template>
<table class="table table-hover">
	<thead is="offer-sorters"></thead>

	<tbody is="offer-row" 
		v-for="offer in offers"
		:offer="offer" ></tbody>
</table>
</template>

<script>
module.exports = {
	props: ['offers'],

	components: {
		offerRow: require('./offerRow.vue'),
		offerSorters: require('./offerSorters.vue')
	}
}
</script>