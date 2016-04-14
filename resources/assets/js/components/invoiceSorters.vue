<template>
<thead class="u-unselectable">
	<tr>
		<th class="u-active" style="width: 50px" @click="sortInput('id')">
			ID <sort-icon key="id" mode="invoices"></sort-icon>
		</th>
		<th class="u-active" @click="sortInput('name')">
			Name <sort-icon key="name" mode="invoices"></sort-icon>
		</th>
		<th class="u-active text-right hidden-xxxs" style="width: 95px" @click="sortInput('subtotal')">
			<sort-icon key="subtotal" mode="invoices"></sort-icon> Subtotal
		</th>
		<th class="text-center hidden-xxxs" style="width: 75px">Status</th>
		<th style="width: 60px" class="hidden-xxs"></th>
	</tr>
</thead>
</template>

<script>
module.exports = {
	components: {
		sortIcon: require('./sortIcon.vue')
	},

	methods: {
		sortInput (key) {
			this.setSort('invoices', key)
			this.$dispatch('GET')
		}
	},

	vuex: {
		actions: require(`../vuex/actions/dataTables.js`)
	}
}
</script>