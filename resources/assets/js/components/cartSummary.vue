<template>
<ul class="dropdown-menu">
	<li class="header">You have {{ count.total }} {{ count.total | pluralize 'item' }} in your cart.</li>
	<li>
		<ul class="menu">
			<cart-offer :id="$key" v-for="offer in offers" v-ref:offers></cart-offer>
		</ul>
	</li>
	<li>
		<li class="footer"><a v-link="{ path: '/new-invoice' }">Subtotal: {{ subTotal / 100 | currency }} - Add Invoice</a></li>
	</li>
</ul>
</template>

<script>
module.exports = {
	computed: {
		subTotal () {
			var subTotal = 0
			for (var offerId in this.$refs.offers) {
				subTotal += this.$refs.offers[offerId].subTotal
			}
			return subTotal
		}
	},

	components: {
		cartOffer: require('./cartOffer.vue')
	},

	vuex: {
		getters: {
			count: state => state.cart.count,
			offers: state => state.cart.offers
		},
		actions: require('../vuex/actions/cart.js')
	}
}
</script>