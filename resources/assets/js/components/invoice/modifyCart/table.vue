<template>
<span>
	<table class="table">
		<thead>
			<tr>
				<th style="width: 30px;"></th>
				<th>Item</th>
				<th style="width: 140px;" class="text-right">Unit Cost</th>
				<th style="width: 65px;">Count</th>
				<th style="width: 30px;"></th>
			</tr>
		</thead>

		<tbody is='row' 
			v-for="item in cart.items" 
			v-ref:rows
			track-by="$index"
			:index="$index" 
			:item="item">
		</tbody>
		<tbody is='newRow' :items="cart.items"></tbody>
	</table>
</span>
</template>

<script>
module.exports = {
	props: ['cart'],

	components: {
		row: require('./row.vue'),
		newRow: require('./newRow.vue')
	},

	computed: {
		hasErrors () {
			for (var i = 0; i < this.$refs.rows.length; i++) {
				if (this.$refs.rows[i].hasError) {
					return true
				}
			}
			return false
		}
	}
}
</script>