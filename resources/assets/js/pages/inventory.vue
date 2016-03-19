<template>
<div class="row">
	<div class="col-xs-12">
		<inventory-table></inventory-table>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		inventoryTable: require('../components/inventoryTable.vue')
	}
}
</script>