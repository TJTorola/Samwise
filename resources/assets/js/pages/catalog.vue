<template>
<div class="row" v-if="loaded">
	<div class="col-xs-12 form-horizontal">
		<div class='box box-primary'> <!-- START Catalog Info -->
			<div class='box-header'>
				<h3 class='box-title'>Basic Information</h3>

				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div class="col-xs-12">

					<div class="form-group">
	          <label for="name" class="col-sm-2 control-label">Name:</label>
	          <div class="col-sm-10">
	            <input type="name" maxlength="255" class="form-control" id="name" v-model="catalog.name">
	          </div>
	        </div>

	        <div class="form-group">
	          <label for="description" class="col-sm-2 control-label">Description:</label>
	          <div class="col-sm-10">
	          	<textarea class="form-control" id="description" rows="5" v-model="catalog.description"
	          		placeholder="This appears at the top of the catalog."></textarea>
	          </div>
	        </div>
	      </div>
			</div>
		</div> <!-- END Catalog Info -->
	</div>
	<div class="col-md-6 col-xs-12">
		<tags :tag-string.sync='catalog.tags'></tags>
	</div>
	<div class="col-md-6 col-xs-12">
		<div class="col-xs-12 col-sm-4 col-md-12">
				<button class="btn btn-sm btn-block btn-primary" id="save-catalog" @click="saveCatalog">
					<status-icon icon="fa-floppy-o" v-ref:status></status-icon> Save Catalog
				</button>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-12">
				<button class="btn btn-sm btn-block btn-info" @click="discardChanges">
					<i class="fa fa-repeat"></i> Discard Changes
				</button>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-12">
				<button class="btn btn-sm btn-block btn-danger" @click="deleteCatalog">
					<i class="fa fa-trash"></i> Delete Catalog
				</button>
			</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			id: this.$route.params.id,
			loaded: false,
			catalog: {},
		}
	},

	route: {
		data () {
			this.getCatalog();
		}
	},

	components: {
		'tags': require('app/components/tags.vue'),
		'statusIcon': require('app/components/statusIcon.vue')
	},

	methods: {
		getCatalog () {
			this.$http.get('catalog/' + this.id).then(function (response) {
				this.$set('catalog', response.data)
				this.loaded = true
			})
		},

		discardChanges () {
			if (confirm("Are you sure? This will discard all changes you have made so far.")) {
				window.location.reload()
			}
		},

		saveCatalog () {
			this.$refs.status.working()

			this.$http.patch('/admin/catalogs/'+this.catalog.id, this.catalog).then(function(response) {
				if (response.data) {
					this.$dispatch('notification', {type: 'info', title: 'Success', message: 'The catalog was saved.', timeout: 3})
					this.getCatalog()
				} else {
					this.$dispatch('notification', {type: 'danger', title: 'Error', message: 'There was an error saving the catalog.', timeout: 0})
				}

				this.$refs.status.check()
			}, function() { // Error Catcher
				this.$refs.status.fail()
			})
		},

		deleteCatalog () {
			if (confirm("Are you sure? This will permenantly delete the Catalog.")) {
				this.$http.delete('/admin/catalogs/'+this.catalog.id).then(function(response) {
					if (response.data) {
						window.location.href = "#!/catalogs"
					} else {
						this.$dispatch('notification', {type: 'danger', title: 'Error', message: 'There was an error deleting the catalog.', timeout: 0})
					}
				})
			}
		}
	}
}
</script>