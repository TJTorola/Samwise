<template>
<tbody>
	<tr>
		<td></td>

		<td class="u-input-sm-height u-active" @click="addItem">
			<i class="fa fa-plus"></i> Add New Unstocked Item
		</td>

		<td></td>
		<td></td>
		<td></td>
	</tr>
</tbody>
</template>

<script>
module.exports = {
	props: ['items'],

	methods: {
		addItem () {
			this.items.push({
				id: null,
				item_id: null,
				name: '',
				price: '0',
				count: '0',
				unit: 'Unit'
			})
		}
	}
}
</script>