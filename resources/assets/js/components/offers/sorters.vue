<template>
<thead class="u-unselectable">
	<tr>
		<th class="u-active" style="width: 50px" @click="sortInput('id')">
			ID <sort-icon key="id" mode="offers"></sort-icon>
		</th>
		<th class="u-active" @click="sortInput('name')">
			Name <sort-icon key="name" mode="offers"></sort-icon>
		</th>
		<th class="u-active text-right" @click="sortInput('price')">
			<sort-icon key="price" mode="offers"></sort-icon> Price
		</th>
		<th class="u-active text-right" style="width: 75px;" @click="sortInput('sold')">
			<sort-icon key="sold" mode="offers"></sort-icon> Sold
		</th>
		<th class="u-active text-right" style="width: 75px;" @click="sortInput('stock')">
			<sort-icon key="stock" mode="offers"></sort-icon> Stock
		</th>
		<th style="width: 60px"></th>
	</tr>
</thead>
</template>

<script>
// offers/sorters.vue
module.exports = {
	components: {
		sortIcon: require('app/components/dataTable/sortIcon.vue')
	},

	methods: {
		sortInput (key) {
			this.setSort('offers', key)
			this.$dispatch('GET')
		}
	},

	vuex: {
		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>