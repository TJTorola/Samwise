<template>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-picture-o"></i> Pictures</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body">
		<div class="col-xs-4" 
			v-for="picture in pictures"
			:class="($index % 3 == 0)?'clear-row':''">
			<picture 
				:picture="picture"
				:index="$index"
				:pictures="pictures"
				:deleted="deleted"
				:offer-id="offerId">
			</picture>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['pictures', 'offerId', 'deleted'],

	components: {
		picture: require('./picture.vue')
	}
}
</script>