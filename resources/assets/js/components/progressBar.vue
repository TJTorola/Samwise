<template>
<div class="progress progress-sm active">
	<div class="progress-bar progress-bar-primary progress-bar-striped" :style="`width: ${progress}%`"></div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			percent: 0,
			step: 0,
		}
	},

	computed: {
		span () {
			if (this.steps) {
				return Math.ceil(100 / this.steps)	
			} else {
				return 100
			}
		},

		min () {
			return this.span * this.step
		},

		max () {
			return (this.span + 1) * this.step
		},

		progress () {
			return Math.ceil((this.span * this.percent) / 100) + this.min
		}
	},

	watch: {
		files () {
			this.reset()
		}
	},

	props: ['steps'],

	watch: {
		steps () {
			this.reset()
		}
	},

	methods: {
		reset () {
			this.progress = 0
			this.step = 0
		},

		next () {
			this.step++
			this.percent = 0
		}
	}


}
</script>