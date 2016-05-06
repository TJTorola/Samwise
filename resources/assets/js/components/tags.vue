<template>
<div class='box box-warning'>
	<div class='box-header'>
		<h3 class='box-title'><i class="fa fa-tags"></i> Tags</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body">
		<div class="col-xs-12">
			<div class="tag" v-for="tag in tags" @click="tags.splice($index, 1)">{{ tag }}</div>
			<div class="tag is-new" v-if="newTag" @click="newTag=''">{{ newTag }}</div>
			<hr v-if="tags.length > 0">
			<div class="input-group">
        <input type="text" class="form-control" v-model="newTag" @keyup.enter="addTag" list="tagList">
        <datalist id="tagList">
        	<option value="{{ tag }}" v-for="tag in tagList"></option>
        </datalist>
        <span class="input-group-btn">
          <button class="btn btn-primary" type="button" @click="addTag"><i class="fa fa-plus"></i> Add New Tag</button>
        </span>
      </div>
      <br>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		if (this.tagString.length) {
			 var tags = this.tagString.split(',')
		} else {
			 var tags = []
		}

		this.$http.get('tags').then(function(response) {
			this.$set('tagList', response.data)
		})

		return {
			tags: tags,
			newTag: '',
			tagList: [],
		}
	},

	props: ['tagString'],

	watch: {
		tagString () {
			if (this.tagString.length) {
				this.tags = this.tagString.split(',')
			} else {
				this.tags = []
			}
		},

		tags () {
			this.tagString = this.tags.join(',')
		}
	},

	methods: {
		addTag: function() {
			if ($.inArray(this.newTag, this.tags) == -1 && this.newTag != '') {
				this.tags.push(this.newTag)
			}

			this.newTag = ''
		},
	}
}
</script>