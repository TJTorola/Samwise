<template>
<tbody>
	<tr>
		<td>
			<add-to-cart :item-id="item.id" :offer-id="offer.id" v-if="item.id"></add-to-cart>
			<button type="button" class="btn btn-block btn-xs u-no-margin" v-else disabled>
				+ <i class="fa fa-shopping-cart"></i>
			</button>
		</td>
		<td style="white-space:nowrap;">{{ offer.name }} -</td>
		<td class="input-cell">
			<input type="text" v-model="item.name">
		</td>
		<td class="input-cell">
			<input type="text" class="text-right"
				:mask-value="item.price"
				:mask-input="setPrice"
				v-mask:rtl
				mask="#,###,###.##"
				hint=".00">
		</td>

		<td v-if="item.unit == 'Unit'" class='u-active' @click="item.unit = ''" colspan="2">
			/ Unit
		</td>

		<td v-if="item.unit != 'Unit'" class='u-active' @click="item.unit = 'Unit'">/</td>
		<td v-if="item.unit != 'Unit'" class="input-cell">
			<input type="text" v-model="item.unit"></input>
		</td>

		<td v-if="item.infinite">
			∞
		</td>
		<td class="input-cell" v-else>
			<input type="text" v-model="item.stock">
		</td>
		<td class="u-active" @click="item.infinite = !item.infinite">
			∞
		</td>

		<td class="input-cell">
			<input type="text" v-model="item.store_reserve">
		</td>

		<td v-if="offer.items.length > 1">
			<button type="button" class="btn btn-block btn-xs u-no-margin" 
				@click="(expandedIndex != index)?expandedIndex = index:expandedIndex = -1">
				<i class="fa fa-plus" v-if="expandedIndex != index"></i>
				<i class="fa fa-minus" v-else></i> <i class="fa fa-search"></i>
			</button>
		</td>
	</tr>
	<tr v-if="expandedIndex == index || offer.items.length == 1" class="dark">
		<td colspan="10">
			<general-form :item="item"></general-form>
			<type-form :item="item" :offer-type="offer.type"></type-form>
			<div class="col-xs-offset-8 col-xs-4" v-if="offer.items.length > 1">
				<confirmed-button icon="fa-trash" text="Delete Item" 
					color="btn-danger"
					:action="delete" 
					v-ref:delete>
				</confirmed-button>
			</div>
		</td>
	</tr>
</tbody>
</template>

<script>
module.exports = {
	props: ['item', 'index', 'expandedIndex', 'offer'],

	components: {
		confirmedButton: require('app/components/confirmedButton.vue'),
		generalForm: require('./generalForm.vue'),
		typeForm: require('./typeForm.vue'),
		addToCart: require('app/components/offers/addToCart.vue')
	},

	methods: {
		delete () {
			this.offer.items.splice(this.index, 1)
		},

		setPrice (price) {
			this.item.price = parseFloat(price) * 100
		}
	}
}
</script>

<style>
.input-cell {
	padding: 3px !important;
	height: 35px;
}

.input-cell input {
	border-width: 0 0 2px 0;
	width: 100%;
	height: 100%;
}

.input-cell input:focus {
	outline: none;
	border-color: #3c8dbc !important;
}

.input-cell input:hover {
	border-color: #A2C6DA;
}

tr.dark {
	background: #f9f9f9;
}
</style>