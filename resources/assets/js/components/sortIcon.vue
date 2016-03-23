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
			sort: state => state.inventory.sort,
			sortSecond: state => state.inventory.sortSecond
		}
	}
}
</script>