<template>
	<i class="fa fa-fw" :class="activeIcons.join(' ')"></i>
</template>

<script>
module.exports = {
	data () {
		return {
			activeIcons: [this.icon]
		}
	},

	props: ['icon'],

	methods: {
		working () {
			this.activeIcons = ['fa-cog', 'fa-spin']
		},

		check () {
			this.activeIcons = ['fa-check']

			setTimeout(function() {
				this.activeIcons = [this.icon]
			}.bind(this), 1000)
		},

		fail () {
			this.activeIcons = ['fa-times']

			setTimeout(function() {
				this.activeIcons = [this.icon]
			}.bind(this), 1000)
		}
	}
}
</script>