<template>
<div class="btn-group btn-group-sm btn-group-justified" role="group">
  <div class="btn btn-default" v-if="confirming" @click="confirmed">
  	<i class="fa fa-check"></i>
  </div>
  <span class="input-group-addon" v-if="confirming" style="width: 3%">
  	<i class="fa" :class="icon"></i> 
  	<span v-if="buttonWidth > 230">Are you sure?</span>
  	<span v-if="buttonWidth > 160 && buttonWidth <= 230">You sure?</span>
  	<span v-if="buttonWidth <= 160">Sure?</span>
  </span>
  <div class="btn btn-default" v-if="confirming" @click="confirming = false">
  	<i class="fa fa-times"></i>
  </div>
  <div class="btn btn-sm" 
  	:class="(color)?color:'btn-default'" 
  	v-if="!confirming" @click="confirm"
  	:disabled="disabled">
		<status-icon :icon="icon" v-ref:status></status-icon> {{ text }}
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			buttonWidth: 0,
			confirming: false,
			disabled: false
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
			this.$nextTick(() => {
				this.working()
			})
		},

		confirm () {
			this.buttonWidth = this.$el.clientWidth
			this.confirming = true
		},

		working () {
			this.disabled = true
			this.$refs.status.working()
		},

		check () {
			this.disabled = false
			this.$refs.status.check()
		},

		fail () {
			this.disabled = false
			this.$refs.status.fail()
		}
	}
}
</script>