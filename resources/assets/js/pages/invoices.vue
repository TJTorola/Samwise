<template>
<div class="row">
	<div class="col-xs-12">
		<invoices-table></invoices-table>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		invoicesTable: require('../components/invoicesTable.vue')
	}
}
</script>