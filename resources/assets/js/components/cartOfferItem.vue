<template>
<p class="u-unselectable">
	{{ item.name }} {{ item.price / 100 | currency }} / <i>{{ item.unit }}</i><br>
	<i class="fa fa-chevron-down" :class="(count)?'active':''" @click.stop="decrament"></i>
	{{ count }}
	<i class="fa fa-chevron-up active" @click.stop="incrament"></i> 
	(Stock: {{ (item.infinite)?'∞':item.stock }})
	<span class="pull-right">
		{{ subTotal / 100 | currency }}
	</span>
</p>
</template>

<script>
module.exports = {
	computed: {
		count () {
			if (this.cart.offers[this.offerId]) {
				if (this.cart.offers[this.offerId][this.item.id]) {
					return this.cart.offers[this.offerId][this.item.id]
				} else {
					return 0
				}
			} else {
				return 0
			}
		},

		subTotal () {
			return this.item.price * this.count
		}
	},

	props: ['item', 'offerId'],

	methods: {
		incrament() {
			this.addToCart(this.offerId, this.item.id)
		},

		decrament() {
			this.removeFromCart(this.offerId, this.item.id)
		}
	},

	vuex: {
		getters: {
			cart: state => state.cart
		},

		actions: require('../vuex/actions/cart.js')
	}
}
</script>