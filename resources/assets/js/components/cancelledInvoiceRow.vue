<template>
<tr>
	<td>{{ invoice.id }}</td>
	<td>{{ invoice.last_name }}, {{ invoice.first_name }}</td>
	<td class="text-right hidden-xxxs">{{ invoice.subtotal / 100 | currency }}</td>
	<td>
		<button type="button" class="btn btn-primary btn-block btn-xs u-no-margin" 
			:disabled="working"
			@click="restore">
			Restore? <status-icon icon="fa-mail-reply" v-ref:restore></status-icon>
		</button>
	</td>
	<td>
		<button type="button" class="btn btn-danger btn-block btn-xs u-no-margin" 
			:disabled="working"
			@click="destroy">
			Delete? <status-icon icon="fa-trash" v-ref:destroy></status-icon>
		</button>
	</td>
</tr>
</template>

<script>
module.exports = {
	data () {
		return {
			working: false
		}
	},

	props: ['invoice'],

	components: {
		statusIcon: require('./statusIcon.vue')
	},

	methods: {
		destroy () {
			if (this.working) {
				return
			}
			this.working = true

			this.$refs.destroy.working()
			this.$http.delete(`/api/cancelled-invoice/${this.invoice.id}`).then(response => {
				this.working = false
				this.$refs.destroy.check()
				this.$dispatch('GET')
			}, () => {
				this.working = false
				this.$refs.destroy.fail()
			})
		},

		restore () {
			if (this.working) {
				return
			}
			this.working = true

			this.$refs.restore.working()
			this.$http.patch(`cancelled-invoice/${this.invoice.id}`).then(response => {
				this.working = false
				this.$refs.restore.check()
				this.$dispatch('GET')
			}, () => {
				this.working = false
				this.$refs.restore.fail()
			})
		}
	}
}
</script>