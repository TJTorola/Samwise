<template>
<tbody>
	<tr v-if="item.item_id"> <!-- if the cart_item is still locked to an inventory_item -->
		<td>
			<span href="#" class="u-tooltip u-input-sm-height u-active" @click="item.item_id = null"
				tip="'Unlocking' an item will unlink it from the inventory's stock.">
				<i class="fa fa-lock"></i>
			</span>
		</td>

		<td class="u-input-sm-height">
			{{{ item.name | nl2br }}}
		</td>

		<td class="u-input-sm-height text-right">
			{{ item.price / 100 | currency }}
		</td>

		<td>
			<input type="text" class="u-full-width form-control input-sm"
				:mask-value="item.count"
				v-mask:rtl
				mask="#,###">
		</td>

		<td>
			<i class="fa fa-trash u-active" @click="deleteItem($index)"></i>
		</td>
	</tr>

	<tr v-else> <!-- if the cart_item is unlocked -->
		<td>
			<i class="fa fa-unlock u-input-sm-height u-inactive"></i>
		</td>

		<td>
			<input type="text" class="u-full-width form-control input-sm" v-model="item.name">
		</td>

		<td>
			<input type="text" class="u-full-width form-control input-sm text-right" 
				:mask-value="item.price"
				v-mask:rtl
				mask="#,###,###.##"
				hint=".00">
		</td>

		<td>
			<input type="text" class="u-full-width form-control input-sm"
				:mask-value="item.count"
				v-mask:rtl
				mask="#,###">
		</td>

		<td>
			<i class="fa fa-trash u-active" @click="deleteItem($index)"></i>
		</td>
	</tr>
</tbody>
</template>

<script>
module.exports = {
	props: ['item']
}
</script>