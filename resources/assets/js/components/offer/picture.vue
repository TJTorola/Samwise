<template>
<div class="thumbnail" :class="(picture.saved)?'':'not-saved'">
	<img class="img-responsive img-rounded" :src="`/img/${picture.source}`">
	<div class="btn-group btn-group-xs btn-group-justified margin-top" role="group">
		<a type="button" class="btn btn-default" role="button"
			@click="imgShift(-1)"
			:disabled="index == 0">
			<i class="fa fa-chevron-left"></i>
		</a>
		<a type="button" class="btn btn-danger" role="button"
			@click="pictures.splice(index,1)">
			<i class="fa fa-trash"></i>
		</a>
		<a type="button" class="btn btn-default" role="button"
			@click="imgShift(1)"
			:disabled="index + 1 == pictures.length">
			<i class="fa fa-chevron-right"></i>
		</a>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['picture', 'index', 'pictures', 'offerId'],

	methods: {
		imgShift (shift) {
			if (0 > this.index + shift || this.index + shift >= this.pictures.length) {
				return
			}

			var save = this.pictures[this.index + shift]
  		this.pictures[this.index + shift] = this.pictures[this.index]
  		this.pictures.$set(this.index, save)
		}
	}
}
</script>