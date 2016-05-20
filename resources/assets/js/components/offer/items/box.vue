<template>
<div class="box box-success">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-archive"></i> Item Info</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body no-padding">
		<items-table :offer="offer" :expanded-index="expandedIndex"></items-table>
	</div>
	<div class="box-footer">
		<div class="btn btn-primary pull-right" @click="addItem">
			<i class="fa fa-plus"></i> Add Item
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			expandedIndex: 0
		}
	},

	props: ['items', 'offer'],

	components: {
		itemsTable: require('./table.vue'),
		item: require('./item.vue')
	},

	methods: {
		addItem () {
			this.offer.items.push({
				name: '',
				type: 'auto',
				public: 1,
				x: '',
				y: '',
				z: '',
				weight: '',
				shipping_cost: '',
				location: '',
				unit: 'Unit',
				infinite: false,
				stock: 0,
				store_reserve: 0,
				sold: 0,
				price: 0
			})
			this.expandedIndex = this.offer.items.length - 1
		}
	}
}
</script>