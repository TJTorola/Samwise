<template>
<status-icon class="u-active"
	v-ref:icon
	:icon="(mode == 'billed')?'fa-file-text':(mode == 'paid')?'fa-credit-card':'fa-truck'"
	@click="toggleState"
	:class="state?'u-green':'u-gray'"></status-icon>
</template>

<script>
module.exports = {
	data () {
		return {
			working: false
		}
	},

	props: ['mode', 'state', 'id'],

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		toggleState () {
			if (this.working) {
				return
			}

			this.working = true
			this.$refs.icon.working()

			var request = {}
			request[this.mode] = !this.state
			
			this.$http.patch(`invoice/${this.id}`, request).then(response => {
				this.state = !this.state
				this.$refs.icon.check()
				this.working = false
			}, () => {
				this.$refs.icon.fail()
				this.working = false
			})
		}
	}
}
</script>