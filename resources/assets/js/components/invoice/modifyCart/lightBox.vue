<template>
<div class="lightbox-mask" v-show="show" transition="lightbox">
	<div class="lightbox-wrapper">
		<div class="lightbox-container">
			<div class="lightbox-header">
				<i class="fa fa-shopping-cart"></i> Modify Shopping Cart <br>
				<i class="u-thin">Add and remove items from this invoice's cart.</i>
			</div>

			<div class="lightbox-body" v-if='loaded'>
				<cart-table :cart="cart"></cart-table>

				<search-items :cart="cart"></search-items>
			</div>

			<div class="lightbox-footer">
				<button class="btn btn-sm btn-primary">
					<i class="fa fa-floppy-o"></i> Save Changes
				</button>

				<button class="btn btn-sm pull-right" @click="show = false">
					<i class="fa fa-repeat"></i> Discard Changes
				</button>
			</div>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			loaded: false,
			cart: {}
		}
	},

	props: ['show', 'id'],

	components: {
		cartTable: require('./table.vue'),
		searchItems: require('./searchItems.vue')
	},

	watch: {
		show () {
			if (this.show) {
				this.loaded = false
				this.total = 0
				this.getCart()
			}
		}
	},

	methods: {
		getCart () {
			this.$http.get(`invoice/${this.id}`).then(response => {
				this.loaded = true
				this.$set('cart', response.data.cart)
			})
		}
	}
}
</script>