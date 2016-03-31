<template>
<div class='box box-primary'>
	<div class='box-header'>
		<h3 class='box-title'>{{ section }}</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body no-padding">
		<table class="table table-striped">
			
		</table>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['section'],


}
</script>