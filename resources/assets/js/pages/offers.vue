<template>
<div class="row">
	<div class="col-xs-12">
		<offers-box></offers-box>
	</div>

	<div class="col-sm-6 col-md-4 col-sm-offset-6 col-md-offset-8">
		<button class="btn btn-sm btn-block" v-link="{ path: '/new-offer'}">
			<i class="fa fa-plus"></i> Offer New Item(s)
		</button>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		offersBox: require('app/components/offers/box.vue')
	}
}
</script>