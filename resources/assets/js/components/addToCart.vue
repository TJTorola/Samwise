<template>
	<button type="button" class="btn btn-block btn-warning btn-xs u-no-margin" 
		@click="incrament" 
		@contextmenu.prevent="decrament">
		{{ (count)?count:'+' }} <i class="fa fa-shopping-cart"></i>
	</button>	
</template>

<script>
module.exports = {
	data () {
		return {
			count: this.cart[this.id]
		}
	},

	props: ['id'],

	methods: {
		incrament() {
			this.addToCart(this.id)
			this.count = this.cart[this.id]
		},

		decrament() {
			this.removeFromCart(this.id)
			this.count = this.cart[this.id]
		}
	},

	vuex: {
		getters: {
			cart: state => state.cart.items
		},

		actions: require('../vuex/actions/cart.js')
	}
}
</script>