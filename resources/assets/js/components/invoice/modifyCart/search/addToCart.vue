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
		inCart () {
			for (var i = 0; i < this.cart.items.length; i++) {
				if (this.cart.items[i].item_id == this.item.id && !(/([^0-9])/g.test(this.cart.items[i].count) || this.cart.items[i].count == '')) {
					return this.cart.items[i]
				}
			}
			return null
		},

		count () {
			if (this.inCart) {
				return this.inCart.count
			}
			return 0
		}
	},

	props: ['cart', 'item'],

	methods: {
		incrament() {
			if (this.inCart) {
				this.inCart.count = (parseInt(this.inCart.count) + 1).toString()
			} else {
				this.cart.items.push({
					id: null,
					item_id: this.item.id,
					name: this.item.full_name,
					price: this.item.price,
					count: 1,
					unit: this.item.unit
				})
			}
		},

		decrament() {
			if (this.inCart) {
				this.inCart.count = (parseInt(this.inCart.count) - 1).toString()
			}
		}
	}
}
</script>