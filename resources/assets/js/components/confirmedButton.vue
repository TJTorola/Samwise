<template>
<div class="btn-group btn-group-sm btn-group-justified" role="group">
  <div class="btn btn-default" v-if="confirming" @click="confirmed">
  	<i class="fa fa-check"></i>
  </div>
  <span class="input-group-addon" v-if="confirming" style="width: 3%">
  	Are you sure?
  </span>
  <div class="btn btn-default" v-if="confirming" @click="confirming = false">
  	<i class="fa fa-times"></i>
  </div>
  <div class="btn btn-sm btn-default" v-if="!confirming" @click="confirming = true">
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

	props: ['icon', 'text', 'action'],

	components: {
		statusIcon: require('./statusIcon.vue')
	},

	methods: {
		confirmed () {
			this.confirming = false
			this.action()
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