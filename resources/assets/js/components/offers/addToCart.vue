<template>
<button type="button" class="btn btn-block btn-warning btn-xs u-no-margin" 
	@click="incrament" 
	@contextmenu.prevent="decrament">
	{{ (count)?count:'+' }} <i class="fa fa-shopping-cart"></i>
</button>
</template>

<script>
module.exports = {
	computed: {
		count () {
			if (this.cart.offers[this.offerId]) {
				if (this.cart.offers[this.offerId][this.itemId]) {
					return this.cart.offers[this.offerId][this.itemId]
				} else {
					return 0
				}
			} else {
				return 0
			}
		}
	},

	props: ['offerId', 'itemId'],

	methods: {
		incrament() {
			this.addToCart(this.offerId, this.itemId)
		},

		decrament() {
			this.removeFromCart(this.offerId, this.itemId)
		}
	},

	vuex: {
		getters: {
			cart: state => state.cart
		},

		actions: require('app/vuex/actions/cart.js')
	}
}
</script>