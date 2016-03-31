<template>
<div class="row" v-if="loaded">
	<div class="col-xs-12">
		<div class='box box-primary' v-for="(key, section) in linearPages">
			<div class='box-header'>
				<h3 class='box-title'>{{ key | capitalize }}</h3>

				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
				</div>
			</div>
			<div class="box-body no-padding">
				<table class="table table-striped">
					<tr v-if="section.length == 0">
						<td><b>There are no {{ key }} pages.</b></td>
					</tr>
					<tr v-for="page in section">
						<td>
							<div class="input-group input-group-sm" :style="'margin-left:'+page.depth*37+'px;'">
                <span class="input-group-btn"> <!-- Left -->
                  <button class="btn btn-default" type="button"
                 	:disabled="page.depth == 0"
                  	@click="disown(page)">
                  	<span class="fa fa-chevron-left"></span>
                  </button>
                </span>
                <span class="input-group-btn"> <!-- Right -->
                  <button class="btn btn-default btn-flat" type="button"
                  	:disabled="page.sorting == 0"
                  	@click="adopt(page)">
                  	<span class="fa fa-chevron-right"></span>
                  </button>
                </span>
                <span class="input-group-btn"> <!-- Up -->
                  <button class="btn btn-default btn-flat" type="button"
                  	:disabled="page.sorting == 0"
                  	@click="move(page, -1)">
                  	<span class="fa fa-chevron-up"></span>
                  </button>
                </span>
                <span class="input-group-btn"> <!-- Down -->
                  <button class="btn btn-default btn-flat" type="button"
                  	:disabled="page.sorting * 1 + 1 >= page.family.length"
                  	@click="move(page, 1)">
                  	<span class="fa fa-chevron-down"></span>
                  </button>
                </span>

                <input type="text" class="form-control"
                	:class="checkName(page)?'has-error':''"
                	v-model="page.name"
                	:disabled="page.id == 1">

								<span class="input-group-btn">
                  <a class="btn btn-primary btn-flat" :href="'/admin/page/'+page.id">
										<i class="fa fa-pencil"></i> Edit
                  </a>
                </span>

                <span class="btn-group input-group-btn">
                  <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
										<span class="fa fa-caret-down"></span>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                  	<li class="dropdown-header">Move page to:</li>
                    <li v-if="page.location != 'header'">
                    	<a @click="changeSection(page, 'header')"><i class="fa fa-arrow-up"></i> Header</a>
                    </li>
                    <li v-if="page.location != 'footer'">
                    	<a @click="changeSection(page, 'footer')"><i class="fa fa-arrow-down"></i> Footer</a>
                    </li>
                    <li v-if="page.location != 'hidden'">
                    	<a @click="changeSection(page, 'hidden')"><i class="fa fa-eye-slash"></i> Hidden</a>
                    </li>
                    <li class="divider" v-if="page.id != 1"></li>
                    <li v-if="page.id != 1">
                    	<a @click="deletePage(page)"><i class="fa fa-trash"></i> Delete Page</a>
                    </li>
                  </ul>
                </span>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<button class="btn btn-default pull-right" @click="addPage(key)"><i class="fa fa-plus"></i> Add Page</button>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4 col-md-offset-4 col-xs-6">
				<button class="btn btn-sm btn-block btn-primary save-pages"
					@click="savePages">
					<status-icon icon="fa-floppy-o" v-ref:status></status-icon> Save Pages
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
			pages: [],
			deletedPages: [],
		}
	},

	route: {
		data () {
			this.getPages()
		}
	},

	components: {
		statusIcon: require('../components/statusIcon.vue')
	},

	computed: {
		linearPages () {
			return {
				header: this.parsePages('header'),
				footer: this.parsePages('footer'),
				hidden: this.parsePages('hidden'),
			}
		},

		pagesRequest () {
			var request = []

			var loc = ['header', 'footer', 'hidden']
			for (var i = 0; i < loc.length; i++) {
				for (var j = 0; j < this.linearPages[loc[i]].length; j++) {
					var requestPage = this.linearPages[loc[i]][j]
					var page = {
						id: requestPage.id,
						name: requestPage.name,
						parent_id: requestPage.parent_id,
						location: requestPage.location,
						depth: requestPage.depth,
						sorting: requestPage.sorting,
					}
					request.push(page)
				}
			}

			return request
		}
	},

	methods: {
		getPages () {
			// var page = require('../store/page.js')
		 //  page.state.title = 'Pages'
		 //  page.state.description = ''

		  this.$http.get('pages').then(function (response) {
				this.$set('pages', response.data)
				this.$set('deletedPages', [])
				this.loaded = true
			})
		},

		savePages () {
			this.$refs.status.working()

			// generate request
			var request = { pages: this.pagesRequest, delete: this.deletedPages }

			this.$http.post('pages', request).then(function (response) {
				this.$refs.status.check()
				this.getPages()
			}, function() {
				this.$refs.status.fail()
			})
		},

		discardChanges () {
			if (confirm("Are you sure? This will discard all changes you have made so far.")) {
				this.getPages()
			}
		},

		parsePages (location, input = null, depth = 0, parent = null) {
			if (input == null) {
				input = this.pages[location]
			}
			var returnArray = []

			for (var i = 0; i < input.length; i++) {
				if (parent === null) {
					input[i].parent_id = null
				} else {
					input[i].parent_id = parent.id
				}
				input[i].location = location
				input[i].depth = depth
				input[i].sorting = i
				input[i].family = input
				input[i].parent = parent

				returnArray.push(input[i])
				returnArray = returnArray.concat(this.parsePages(location, input[i]['children'], depth + 1, input[i]))
			}

			return returnArray
		},

		adopt (child) {
			var index = child['family'].indexOf(child)
			var eldest = child['family'][index - 1]
			child['family'].splice(index, 1)
			eldest['children'].push(child)
			this.update(eldest)
		},

		disown (child) {
			var index = child['family'].indexOf(child)
			var parent = child['parent']
			var parentIndex = parent['family'].indexOf(parent)
			child['family'].splice(index, 1)
			parent['family'].splice(parentIndex + 1, 0, child)
			this.update(parent)
		},

		move (child, distance) {
			var family = child['family']
			var index = family.indexOf(child)
			family.splice(index, 1)
			family.splice(index + distance, 0, child)
		},

		update (page) {
			var Vue = require('vue')
			var family = page['family']
			var index = family.indexOf(page)
			family.splice(index, 1)
			Vue.nextTick(function() {
				family.splice(index, 0, page)
			})
		},

		changeSection (page, newSection) {
			var index = page['family'].indexOf(page)
			var eldest = page['family'][index - 1]
			page['family'].splice(index, 1)
			this.pages[newSection].push(page)

			this.update(eldest)
		},

		deletePage (page) {
			if (confirm("Are you sure? This will permanently delete the page and all it's child pages.")) {
				var index = page['family'].indexOf(page)
				var eldest = page['family'][index - 1]
				page['family'].splice(index, 1)
				this.deletePageRecursion([page])

				this.update(eldest)
			}
		},

		deletePageRecursion (pages) {
			for (var i = 0; i < pages.length; i++) {
				if (pages[i].id) {
					this.deletedPages.push(pages[i].id)
				}
				if (pages[i].children.length > 0) {
					this.deletePageRecursion(pages[i].children)
				}
			}
		},

		addPage (location) {
			var newPage = {
				name: 'New Page',
				parent_id: null,
				sorting: this.pages[location].length,
				location: location,
				depth: 0,
				search: 1,
				children: [],
			}

			this.pages[location].push(newPage)
		},

		checkName(page) {
			var helper = require('../helper.js')

			if (helper.testName(page.name)) {
				return true
			}

			var index = page['family'].indexOf(page)
			for (var i = 0; i < page['family'].length; i++) {
				if (i != index && helper.makeSlug(page['family'][i].name) == helper.makeSlug(page.name)) {
					return true
				}
			}
			return false
		}
	}
}
</script>
