<template>
<div class='box box-info'> <!-- Picture Upload -->
	<div class='box-header'>
		<h3 class='box-title'><i class="fa fa-file-image-o"></i> Upload Images</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<label for="uploader" style="width: 100%;">
			<div class="btn btn-sm btn-primary btn-block" :class="working?'disabled':''">
				<status-icon icon="fa-upload" v-ref:upload></status-icon> {{ status }}
			</div>
		</label>
		<input type="file" name="img" accept="image/bmp,image/gif,image/jpeg,image/png" id="uploader" multiple 
			v-el:uploader 
			class="u-hiddenNotHidden"
			@change="start" 
		>
		<br>
		<progress-bar :steps="selectedCount" v-ref:progress></progress-bar>
	</div>
</div>
</template>

<script>
module.exports = {
	data: function() {
		return {
			working: false,
			uploadedCount: 0,
			percent: 0,
			index: 0,
			count: 0,
			errors: [],
			files: []
		}
	},

	props: ['offerId'],

	computed: {
		selectedCount () {
			return this.files.length
		},

		status () {
			if (this.selectedCount == 0 && this.uploadedCount == 0) {
				return 'Select Images to Upload'
			} else if (this.selectedCount == 1) {
				return `1 Image Selected (${this.uploadedCount} Uploaded)`
			} else {
				return `${this.selectedCount} Images Selected (${this.uploadedCount} Uploaded)`
			}
		}
	},

	components: {
		progressBar: require('app/components/progressBar.vue'),
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		start (e) {
			e.preventDefault()
			this.working = true
			this.$refs.upload.working()
			this.files = this.$els.uploader.files
			this.uploadedCount = 0

			if (this.selectedCount > 0) {
				this.upload()
			} else {
				this.end()
			}
		},

		upload () {
			var options = {
				upload: {
					onprogress: (e) => {
						var percent = parseInt(e.loaded / e.total * 100)
						this.$refs.progress.percent = percent
					}
				}
			}

			var request = new FormData()
			request.append('picture', this.files[this.uploadedCount])

			this.$http.post(`offer/${this.offerId}/image`, request, options).then(response => {
				this.$refs.progress.next()
				this.$dispatch('NEW_PICTURE', response.data)

				this.uploadedCount++
				if (this.uploadedCount < this.selectedCount) {
					this.upload()
				} else {
					this.end()
				}
			}, () => {
				this.$refs.progress.next()
				// TODO: THROW ERR

				this.uploadedCount++
				if (this.uploadedCount < this.selectedCount) {
					this.upload()
				} else {
					this.end()
				}
			})
		},

		end () {
			this.working = false
			this.$refs.upload.check()

			setTimeout(() => {
				if (!this.working) {
					this.files = []
					this.uploadedCount = 0
				}
			}, 5000)
		}
	}
}
</script>