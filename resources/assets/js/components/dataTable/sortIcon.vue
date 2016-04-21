<template>
	<i :class="(sort.key == key)?sort.ascending?'fa fa-sort-amount-asc':'fa fa-sort-amount-desc':''"></i>
	<i class="u-translucent"
		v-if="sortSecond != null"
		:class="(sortSecond.key == key)?sortSecond.ascending?'fa fa-sort-amount-asc u-trans':'fa fa-sort-amount-desc':''"></i>
</template>
<script>
module.exports = {
	props: ['key', 'mode'],

	computed: {
		sort () {
			if (this.mode == 'invoices') {
				return this.invoicesSort
			} else if (this.mode == 'offers') {
				return this.offersSort
			}
		},

		sortSecond () {
			if (this.mode == 'invoices') {
				return this.invoicesSortSecond
			} else if (this.mode == 'offers') {
				return this.offersSortSecond
			}
		}
	},

	vuex: {
		getters: {
			invoicesSort: state => state.invoices.sort,
			invoicesSortSecond: state => state.invoices.sortSecond,
			offersSort: state => state.offers.sort,
			offersSortSecond: state => state.offers.sortSecond,
		}
	}
}
</script>