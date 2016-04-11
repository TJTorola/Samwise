<template>
<div class="row">
	<modify-cart></modify-cart>

	<customer-info></customer-info>
</div>
</template>

<script>
module.exports = {
	components: {
		modifyCart: require('../components/modifyCart.vue'),
		customerInfo: require('../components/customerInfo.vue')
	}
}
</script>