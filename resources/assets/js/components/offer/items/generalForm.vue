<template>
<div class="form-horizontal">
	<div class="form-group">
		<label for="weight" class="col-sm-2 control-label">Weight: <small>(lb.)</small></label>
		<div class="col-sm-10">
			<input type="text" class="form-control" id="weight" v-model="item.weight">
		</div>
	</div>


	<div class="form-group">
		<label class="col-sm-2 control-label">Size: <small>(in)</small></label>
		<div class="col-xs-12 col-sm-10">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
				<input type="text" class="form-control" id="x" v-model="item.x">
				<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
				<input type="text" class="form-control" id="y" v-model="item.y">
				<span class="input-group-addon"><i class="fa fa-expand"></i></span>
				<input type="text" class="form-control" id="z" v-model="item.z">
			</div>
		</div>
	</div>

	<div class="form-group">
		<label for="location" class="col-sm-2 control-label">location:</label>
		<div class="col-sm-10">
			<input type="name" maxlength="255" class="form-control" id="location" v-model="item.location">
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['item']
}
</script>