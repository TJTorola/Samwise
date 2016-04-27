<template>
<div class='box box-danger collapsed-box'>
	<div class='box-header'>
		<h3 class='box-title'>
			<status-icon icon="fa-shopping-cart" v-ref:status></status-icon> Modify Cart
		</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
		</div>
	</div>

	<div class="box-body">
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		statusIcon: require('app/components/statusIcon.vue')
	}
}
</script>