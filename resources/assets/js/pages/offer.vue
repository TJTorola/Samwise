<template>
<div class="row" v-if="loaded">
	<div class="col-xs-12">
		<offer-info :offer="offer"></offer-info>
	</div>

	<div class="col-xs-12">
		<items :offer="offer"></items>
	</div>

	<div class="col-xs-12 col-md-6">
		<tags :tag-string.sync="offer.tags"></tags>

		<picture-upload :offer-id="offer.id"></picture-upload>

		<pictures v-if="offer.pictures.length > 0"
			:pictures="offer.pictures"
			:deleted="offer.deleted_pictures"
			:offer-id="offer.id">
		</pictures>
	</div>
	<div class="col-xs-12 col-md-6">
		<type-info :offer="offer"></type-info>
	</div>

	<div class="col-xs-12">
		<div class="col-md-4 col-xs-12">
			<button class="btn btn-sm btn-block btn-primary" id="save-item" @click="store">
				<status-icon icon="fa-floppy-o" v-ref:store></status-icon> Save Offer
			</button>
		</div>

		<div class="col-md-4 col-xs-12">
			<confirmed-button icon="fa-repeat"
				v-if="offer.id"
				text="Discard Changes"
				color="btn-info"
				:action="discard"
				v-ref:discard>
			</confirmed-button>
		</div>

		<div class="col-md-4 col-xs-12">
			<confirmed-button icon="fa-trash"
				text="Delete Offer"
				color="btn-danger"
				:action="deleteOffer"
				v-ref:delete>
			</confirmed-button>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			loaded: false,
			id: 0,
			offer: {}
		}
	},

	route: {
		data () {
			this.loaded = false
			this.$set('id', this.$route.params.id)
			this.get()
		}
	},

	components: {
		items: require('app/components/offer/items/box.vue'),
		offerInfo: require('app/components/offer/offerInfo.vue'),
		tags: require('app/components/tags.vue'),
		pictureUpload: require('app/components/offer/pictureUpload.vue'),
		pictures: require('app/components/offer/pictures.vue'),
		typeInfo: require('app/components/offer/typeInfo.vue'),
		confirmedButton: require('app/components/confirmedButton.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	events: {
		NEW_PICTURE (fileName) {
			this.offer.pictures.push({
				id: null,
				source: {
					lg: `tmp/${fileName}`
				},
			})
		}
	},

	methods: {
		get () {
			this.$http.get(`offer/${this.id}`).then(response => {
				response.data['deleted_pictures'] = []
				response.data['deleted_items'] = []
				this.$set('offer', response.data)
				this.loaded = true
				if (this.$refs.discard) {
					this.$refs.discard.check()
				}
			})
		},

		store () {
			this.$refs.store.working()

			console.log(this.offer);

			this.$http.patch(`offer/${this.offer.id}`, this.offer).then(response => {
				response.data['deleted_pictures'] = []
				this.$set('offer', response.data)
				this.$refs.store.check()
			}, () => {
				this.$refs.store.fail()
			})
		},

		discard () {
			this.get()
		},

		deleteOffer () {
			this.$http.delete(`offer/${this.offer.id}`).then(response => {
				this.$router.go({ path: '/offers' })
			})
		}
	}
}
</script>
