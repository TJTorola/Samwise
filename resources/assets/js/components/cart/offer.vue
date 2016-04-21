<template>
<li v-if="loaded">
	<div class="pull-left">
		<img src="/img/def.jpg">
	</div>
	<h4>
		<a>{{ offer.name }}</a>
	</h4>
	<item v-for="item in offer.items" :item="item" :offer-id="offer.id" v-ref:items/>
</li>
</template>

<script>
module.exports = {
	data () {
		return {
			loaded: false,
			offer: {}
		}
	},

	computed: {
		subTotal () {
			if (!this.loaded) {
				return 0
			}
			
			var subTotal = 0
			for (var i = 0; i < this.$refs.items.length; i++) {
				subTotal += this.$refs.items[i].subTotal
			}
			return subTotal
		}
	},

	components: {
		item: require('./offerItem.vue')
	},

	created () {
		this.$http.get(`offer/${this.id}/admin`).then(function(response) {
			this.$set('offer', response.data)
			this.loaded = true
		})
	},

	props: ['id']
}
</script>