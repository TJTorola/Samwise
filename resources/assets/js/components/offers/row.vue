<template>
<tbody>
	<tr>
		<td>{{ offer.id }}</td>
		<td>
			<a v-link="{ path: '/offer/'+offer.id }">{{ offer.name }}</a>
		</td>
		<td class="text-right" v-if="offer.price_high == offer.price_low">
			{{ offer.price_high / 100 | currency }}
		</td>
		<td class="text-right" v-else>
			{{ offer.price_low / 100 | currency }} - {{ offer.price_high / 100 | currency }}
		</td>
		<td class="text-right">{{ offer.sold }}</td>
		<td class="text-right" v-if="offer.infinite">∞</td>
		<td class="text-right" v-else>{{ offer.stock }}</td>
		<td v-if="offer.items.length == 1">
			<add-to-cart :item-id="offer.items[0].id" :offer-id="offer.id"></add-to-cart>
		</td>
		<td v-else>
			<button type="button" class="btn btn-block btn-xs u-no-margin" 
				@click="(expandedIndex != offer.id)?expandIndex('offers', offer.id):expandIndex('offers', -1)">
				<i class="fa fa-plus" v-if="expandedIndex != offer.id"></i>
				<i class="fa fa-minus" v-else></i> <i class="fa fa-search"></i>
			</button>
		</td>
	</tr>
	<tr v-if="expandedIndex == offer.id" v-for="item in offer.items" style="background: #F7F7F7;">
		<td></td>
		<td> - {{ item.name }}</td>
		<td class="text-right">{{ item.price / 100 | currency }}</td>
		<td class="text-right">{{ item.sold }}</td>
		<td class="text-right" v-if="item.infinite">∞</td>
		<td class="text-right" v-else>{{ item.stock }}</td>
		<td>
			<add-to-cart :item-id="item.id" :offer-id="offer.id"></add-to-cart>
		</td>
	</tr>
</tbody>
</template>

<script>
// offers/row.vue
module.exports = {
	props: ['offer'],

	components: {
		addToCart: require('./addToCart.vue')
	},

	vuex: {
		getters: {
			expandedIndex: state => state.offers.expandedIndex
		},

		actions: require(`app/vuex/actions/dataTables.js`)
	}
}
</script>