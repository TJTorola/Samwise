<template>
	<i :class="(sort.key == key)?sort.ascending?'fa fa-sort-amount-asc':'fa fa-sort-amount-desc':''"></i>
	<i class="u-translucent"
		v-if="sortSecond != null"
		:class="(sortSecond.key == key)?sortSecond.ascending?'fa fa-sort-amount-asc u-trans':'fa fa-sort-amount-desc':''"></i>
</template>
<script>
module.exports = {
	props: ['key'],

	vuex: {
		getters: {
			sort (state) {
				if (state.page.title == "Invoices") {
					return state.invoices.sort
				} else {
					return state.inventory.sort
				}
			},
			sortSecond (state) {
				if (state.page.title == "Invoices") {
					return state.invoices.sortSecond
				} else {
					return state.inventory.sortSecond
				}
			},
		}
	}
}
</script>