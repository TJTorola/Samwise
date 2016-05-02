<template>
<div class="lightbox-mask" v-show="show" transition="lightbox">
	<div class="lightbox-wrapper">
		<div class="lightbox-container">
			<div class="lightbox-header">
				<i class="fa fa-shopping-cart"></i> Modify Shopping Cart <br>
				<i class="u-thin">Add and remove items from this invoice's cart.</i>
			</div>

			<div class="lightbox-body" v-if='loaded'>
				<cart-table :cart="cart" v-ref:table></cart-table>

				<search-query :cart="cart"></search-query>
			</div>

			<div class="lightbox-body" v-else></div>

			<div class="lightbox-footer">
				<button class="btn btn-sm btn-primary" @click="save">
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
			cart: {},
			deleted: []
		}
	},

	props: ['show', 'id'],

	components: {
		cartTable: require('./table.vue'),
		searchQuery: require('./search/query.vue')
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

	events: {
		DELETE_ITEM_BY_INDEX (index) {
			if (this.cart.items[index].id) {
				this.deleted.push(this.cart.items[index].id)
			}

			this.cart.items.splice(index, 1)
		}
	},

	methods: {
		getCart () {
			this.$http.get(`invoice/${this.id}`).then(response => {
				this.loaded = true
				this.$set('cart', response.data.cart)
			})
		},

		save () {
			if (this.$refs.table.hasErrors) {
				this.$root.notify('danger', 'Invalid Cart', 'Fix errors on cart before submitting.')
			}

			this.$http.post(`invoice/${this.id}`)
		}
	}
}
</script>