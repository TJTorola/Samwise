<template>
<span>
	<div class="btn btn-sm btn-default btn-block" @click="working=true">
		<i class="fa fa-user"></i> Modify Info
	</div>

	<light-box :show.sync="working" :id="invoice.id"></light-box>
</span>
</template>

<script>
module.exports = {
	data() {
		return {
			working: false
		}
	},

	props: ['invoice'],

	components: {
		lightBox: require('./lightBox.vue')
	}
}
</script>