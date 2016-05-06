<template>
<div class="progress progress-sm active">
	<div class="progress-bar progress-bar-primary progress-bar-striped" :style="`width: ${progress}%`"></div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			simulating: false,
			progress: 0,
			step: 0,
		}
	},

	props: ['steps'],

	watch: {
		progress () {
			if (this.progress > this.limit) {
				this.progress = this.limit
			}
		},

		steps () {
			this.reset()
		}
	},

	computed: {
		limit () {
			if (this.steps) {
				return Math.ceil((100 / this.steps) * (this.step + 1))
			} else {
				return 100
			}
		},

		avrStep () {
			if (this.steps) {
				return Math.floor(100 / (this.steps * 20))
			} else {
				return 5
			}
		},

		lowStep () {
			var low = this.avrStep - 2

			if (low < 0) {
				return 0
			} else {
				return low
			}
		},

		highStep () {
			return this.avrStep + 2
		}
	},

	methods: {
		simulateProgress () {
			setTimeout(() => {
				if (this.simulating) {
					this.progress += this.randStep()
					this.simulateProgress()
				}
			}, this.randTime())
		},

		simulate () {
			this.simulating = true
			this.simulateProgress()
		},

		reset () {
			this.simulating = false
			this.step = 0
			this.progress = 0
		},

		next () {
			this.step++

			if (this.steps) {
				this.progress = Math.ceil((100 / this.steps) * this.step)
			} else {
				this.progress = 100
			}
		},

		randStep () {
			return Math.floor((Math.random() * this.highStep) + this.lowStep)
		},

		randTime () {
			return Math.floor((Math.random() * 750) + 250)
		}
	}
}
</script>