<template>
<div class='box box-warning'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-shopping-cart" v-ref:status></status-icon> Cart
		</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body no-padding">
		<items-table :cart="invoice.cart" :id="invoice.id"></items-table>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['invoice'],

	components: {
		statusIcon: require('app/components/statusIcon.vue'),
		itemsTable: require('./itemsTable.vue')
	}
}
</script>