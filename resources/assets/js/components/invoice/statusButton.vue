<template>
<div class="btn btn-sm" @click="toggleState" :class="state?'bg-olive':'btn-default'">
	{{ mode | capitalize }} <status-icon v-ref:icon :icon="icon">
</div>
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

	computed: {
		icon () {
			if (!this.state) {
				return 'fa-times'
			}

			switch (this.mode) {
				case 'billed':
					return 'fa-file-text'
				case 'paid':
					return 'fa-credit-card'
				case 'shipped':
					return 'fa-truck'
			}
		}
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