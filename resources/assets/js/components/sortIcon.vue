<template>
	<i :class="(sort.key == key)?sort.ascending?'fa fa-sort-amount-asc':'fa fa-sort-amount-desc':''"></i>
</template>
<script>
module.exports = {
	props: ['key'],

	vuex: {
		getters: {
			sort: state => state.inventory.sort
		}
	}
}
</script>