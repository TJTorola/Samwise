<template>
<div class="row">
	<div class="col-xs-12">
		<invoices-box></invoices-box>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		invoicesBox: require('app/components/invoices/box.vue')
	}
}
</script>