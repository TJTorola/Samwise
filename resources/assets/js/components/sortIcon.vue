<template>
	<i :class="($parent.sort.key == key)?$parent.sort.ascending?'fa fa-sort-amount-asc':'fa fa-sort-amount-desc':''"></i>
	<i class="u-translucent"
		v-if="$parent.sortSecond != null"
		:class="($parent.sortSecond.key == key)?$parent.sortSecond.ascending?'fa fa-sort-amount-asc u-trans':'fa fa-sort-amount-desc':''"></i>
</template>
<script>
module.exports = {
	props: ['key']
}
</script>