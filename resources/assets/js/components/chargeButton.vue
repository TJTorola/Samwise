<template>
<span>
	<button class="btn btn-sm btn-block btn-primary" @click="charging = true">
		<i class="fa fa-credit-card"></i> Charge
	</button>

	<charge-box :id="id" :show.sync="charging"></charge-box>
</span>
</template>

<script>
module.exports = {
	data() {
		return {
			charging: false
		}
	},

	props: ['id'],

	components: {
		chargeBox: require('./chargeBox.vue')
	}
}
</script>