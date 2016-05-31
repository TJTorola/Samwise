<template>
<div class="box box-default">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-bars"></i> General Info</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body form-horizontal">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">Name:</label>
			<div class="col-sm-10">
				<input type="name" maxlength="255" class="form-control" id="name" v-model="offer.name">
			</div>
		</div>

		<div class="form-group">
			<label for="description" class="col-sm-2 control-label">Description:</label>
			<div class="col-sm-10">
				<textarea class="form-control" rows="6" id="description" v-model="offer.description"></textarea>
			</div>
		</div>

		<div class="col-xs-12">
			<button class="btn btn-default pull-right" v-on:click="offer.public = !offer.public">
				<span v-if="offer.public"><span class="fa fa-eye"></span> Public</span>
				<span v-else><span class="fa fa-eye-slash"></span> Hidden</span>
			</button>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['offer']
}
</script>
