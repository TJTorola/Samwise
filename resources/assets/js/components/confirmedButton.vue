<template>
<div class="btn-group btn-group-sm btn-group-justified" role="group">
  <div class="btn btn-default" v-if="confirming" @click="confirmed">
  	<i class="fa fa-check"></i>
  </div>
  <span class="input-group-addon" v-if="confirming" style="width: 3%">
  	<i class="fa" :class="icon"></i> Are you sure?
  </span>
  <div class="btn btn-default" v-if="confirming" @click="confirming = false">
  	<i class="fa fa-times"></i>
  </div>
  <div class="btn btn-sm" :class="(color)?color:'btn-default'" v-if="!confirming" @click="confirm">
		<status-icon :icon="icon" v-ref:status></status-icon> {{ text }}
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			confirming: false
		}
	},

	props: ['icon', 'text', 'action', 'color'],

	components: {
		statusIcon: require('./statusIcon.vue')
	},

	methods: {
		confirmed () {
			this.confirming = false
			this.action()
		},

		confirm () {
			this.confirming = true
			// setTimeout(function() {
			// 	this.confirming = false
			// }.bind(this),10000)
		},

		working () {
			this.$refs.status.working()
		},

		check () {
			this.$refs.status.check()
		},

		fail () {
			this.$refs.status.fail()
		}
	}
}
</script>