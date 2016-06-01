<template>
<div class="col-xs-12">
	<div class="box box-info"> <!-- Edit Cart -->
		<div class="box-header">
			<h3 class="box-title"><i class="fa fa-shopping-cart"></i> Modify Cart</h3>

			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body no-padding">
			<div class="col-xs-12">
				<ul class="menu">
					<offer :id="$key" v-for="offer in offers" v-ref:offers></offer>
				</ul>

				<h5 class="pull-right"><b>Subtotal: {{ subTotal / 100 | currency }}</b></h5>
			</div>
		</div>
	</div>
</div>
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
		offer: require('./offer.vue')
	},

	vuex: {
		getters: {
			count: state => state.cart.count,
			offers: state => state.cart.offers
		},
		actions: require('app/vuex/actions/cart.js')
	}
}
</script>
