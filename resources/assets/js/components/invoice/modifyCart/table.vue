<template>
<span>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>Item</th>
				<th style="width: 100px;" class="text-right">Unit Cost</th>
				<th style="width: 100px;">Count</th>
				<th></th>
			</tr>
		</thead>

		<tbody is='row' v-for="item in cart.items" :item="item"></tbody>
	</table>
</span>
</template>

<script>
module.exports = {
	props: ['cart'],

	components: {
		row: require('./row.vue')
	}
}
</script>