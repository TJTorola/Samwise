<template>
<div class="row">
	<div class="col-xs-12">
		<div class='box box-danger'>
			<div class='box-header'>
				<h3 class='box-title'><status-icon icon="fa-list-alt" v-ref:status></status-icon> Catalogs</h3>

				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			
			<div class="box-body no-padding">
				<table class="table table-striped" v-if="loaded">
					<tr v-for="catalog in catalogs">
						<td class="u-full">
							<div class="input-group input-group-sm">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" @click="catalog.label = !catalog.label">
										<span class="fa fa-fw fa-check-square-o" v-if="catalog.label"></span>
										<span class="fa fa-fw fa-square-o" v-else></span>
										 Label
									</button>
								</span>	

								<input type="text" class="form-control" v-model="catalog.name" :class="testName($index)?'has-error':''">
								
								<span class="input-group-btn" v-if="catalog.id">
									<a class="btn btn-primary btn-flat" :disabled="catalog.label" v-link="{ path: '/catalog/' + catalog.id }">
										<i class="fa fa-pencil"></i> Edit
									</a>
								</span>
								<span class="input-group-btn" v-else>
									<button class="btn btn-default btn-flat save-catalogs" type="button"
										@click="saveCatalogs">
										<span class="fa fa-floppy-o"></span> Save
									</button>
								</span>

								<span class="input-group-btn">
									<button class="btn btn-default btn-flat" type="button" 
										:disabled="$index == 0"
										@click="shiftCatalog($index, -1)">
										<span class="fa fa-chevron-up"></span>
									</button>
								</span>

								<span class="input-group-btn">
									<button class="btn btn-default" type="button" 
										:disabled="$index == catalogs.length - 1"
										@click="shiftCatalog($index, 1)">
										<span class="fa fa-chevron-down"></span>
									</button>
								</span>
							</span>
						</td>
						<td>
							<button class="btn btn-sm btn-danger" type="button" @click="deleteCatalog($index)">
								<span class="fa fa-trash"></span>
							</button>
						</td>
					</tr>
				</table>
			</div>
			<div class="box-footer">
				<button class="btn btn-sm btn-default pull-right" type="button" @click="addCatalog">
					<span class="fa fa-plus"></span> Add Catalog
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-xs-6">
				<button class="btn btn-sm btn-block btn-primary save-catalogs" 
					@click="saveCatalogs">
					<status-icon icon="fa-floppy-o" v-ref:status></status-icon> Save Catalogs
				</button>
			</div>

			<div class="col-md-4 col-xs-6">
				<button class="btn btn-sm btn-block btn-info" @click="discardChanges">
					<i class="fa fa-repeat"></i> Discard Changes
				</button>
			</div>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return { 
			loaded: false,
			catalogs: [],
			deletedCatalogs: [],
		}
	},

	route: {
		data () {
			this.$refs.status.working()
			this.getCatalogs()
		}
	},

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		getCatalogs () {
			this.$http.get('catalogs').then(function(response) {
				this.$set('deletedCatalogs', [])
				this.$set('catalogs', response.data)
				this.loaded = true
				this.$refs.status.check()
			})
		},

		discardChanges () {
			if (confirm("Are you sure? This will discard all changes you have made so far.")) {
				window.location.reload()
			}
		},

		saveCatalogs () {
			this.$refs.status.working()

			var request = {
				catalogs: [],
				deletedCatalogs: this.deletedCatalogs,
			}

			for (var i = 0; i < this.catalogs.length; i++) {
				var catalog = {
					sorting: i,
					id: this.catalogs[i].id,
					name: this.catalogs[i].name,
					label: this.catalogs[i].label,
				}

				request.catalogs.push(catalog)
			}

			for (var i = 0; i < request.deletedCatalogs.length; i++) {
				request.deletedCatalogs[i] = {
					id: request.deletedCatalogs[i].id,
				}
			}

			this.$http.post('catalogs', request).then(function(response) {
				// this.$dispatch('notification', {type: 'info', title: 'Success', message: 'The catalogs were saved.', timeout: 3})
				this.getCatalogs()
				
				this.$refs.status.check()
			}, function() { // Error Catcher
				this.$refs.status.fail()
			})
		},

		shiftCatalog (index, change) {
			var save = this.catalogs[index + change]
			this.catalogs[index + change] = this.catalogs[index]
			this.catalogs.$set(index, save)
		},

		deleteCatalog (index) {
			if (confirm("Are you sure? This will permanently delete the catalog.")) {
				if (this.catalogs[index].id) {
					this.deletedCatalogs.push(this.catalogs[index])
				}

				this.catalogs.splice(index, 1)
			}
		},

		addCatalog () {
			this.catalogs.push({ name: 'New Catalog', label: false, sorting: this.catalogs.length })
		},

		testName (index) {
			var helper = require('../helper.js')
			var thisCatalog = this.catalogs[index]
			if (helper.testName(thisCatalog.name)) {
				return true
			}

			for (var i = 0; i < this.catalogs.length; i++) {
				var catalog = this.catalogs[i]

				if (catalog !== thisCatalog && helper.makeSlug(catalog.name) == helper.makeSlug(thisCatalog.name)) {
					return true
				}
			}
			return false;
		}
	}
}
</script>