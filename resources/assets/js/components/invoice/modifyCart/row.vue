<template>
<tbody>
	<tr v-if="item.item_id"> <!-- if the cart_item is still locked to an inventory_item -->
		<td>
			<span href="#" class="u-tooltip u-input-sm-height u-active" @click="item.item_id = null"
				tip="'Unlocking' an item will unlink it from the inventory.">
				<i class="fa fa-lock"></i>
			</span>
		</td>

		<td class="u-input-sm-height">
			{{{ item.name | nl2br }}}
		</td>

		<td class="u-input-sm-height text-right">
			{{ item.price / 100 | currency }}
		</td>

		<td :class="(invalidCount)?'has-error':''">
			<input type="text" class="u-full-width form-control input-sm" v-model="item.count">
		</td>

		<td class="u-input-sm-height">
			<i class="fa fa-trash u-active" @click="deleteItem($index)"></i>
		</td>
	</tr>

	<tr v-else> <!-- if the cart_item is unlocked -->
		<td>
			<i class="fa fa-unlock u-input-sm-height u-inactive"></i>
		</td>

		<td :class="(invalidName)?'has-error':''">
			<input type="text" class="u-full-width form-control input-sm" v-model="item.name">
		</td>

		<td>
			<div class="input-group input-group-sm">
				<span class="input-group-addon">
					<i class="fa fa-dollar"></i>
				</span>
				<input type="text" class="u-full-width form-control input-sm text-right" 
					:mask-value="item.price"
					:mask-input="changePrice"
					v-mask:rtl
					mask="#,###,###.##"
					hint=".00">
			</div>
		</td>

		<td :class="(invalidCount)?'has-error':''">
			<input type="text" class="u-full-width form-control input-sm" v-model="item.count" maxlength="4">
		</td>

		<td class="u-input-sm-height">
			<i class="fa fa-trash u-active" @click="deleteItem($index)"></i>
		</td>
	</tr>
</tbody>
</template>

<script>
module.exports = {
	data () {
		return {}
	},

	computed: {
		invalidCount () {
			return /([^0-9])/g.test(this.item.count) || this.item.count == ''
		},

		invalidName () {
			return this.item.name == ''
		},

		hasError () {
			return this.invalidCount || this.invalidName
		}
	},

	props: ['item', 'index'],

	methods: {
		changePrice (price) {
			this.item.price = price
		},

		deleteItem () {
			this.$dispatch('DELETE_ITEM_BY_INDEX', this.index)
		}
	}
}
</script>