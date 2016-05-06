<template>
<div class="form-horizontal">
	<div class="form-group" v-for="field in typeSchema[offerType]">
		<div v-if="field.type == 'string'">
			<label for="{{ field.name }}" class="col-sm-2 control-label">
				<span v-if="field.display_name">{{ field.display_name }}:</span>
				<span v-else>{{ field.name | displayFormat }}:</span>
			</label>
			<div class="col-xs-12 col-sm-10">
				<input type="text" maxlength="255" class="form-control" id="{{ field.name }}" v-model="item[field.name]" :placeholder="field.hint">
			</div>
		</div>

		<div v-if="field.type == 'boolean'">
			<div class="col-xs-12 col-sm-10 col-sm-offset-2">
				<div class="checkbox">
					<label for="{{ field.name }}">
						<input type="checkbox" id="{{ field.name }}" v-model="item[field.name]">
						<b>
							<span v-if="field.display_name">- {{ field.display_name }}</span>
							<span v-else>- {{ field.name | displayFormat }}</span>
						</b>
						<small v-if="field.hint"> {{ field.hint }}</small>
					</label>
				</div>
			</div>
		</div>

		<div v-if="field.type == 'enum'">
			<label for="{{ field.name }}" class="col-sm-2 control-label">
				<span v-if="field.display_name">{{ field.display_name }}:</span>
				<span v-else>{{ field.name | displayFormat }}:</span>
				<small v-if="field.hint"> {{ field.hint }}</small>
			</label>
			<div class="col-xs-12 col-sm-10">
				<select class="form-control" id="{{ field.name }}" v-model="item[field.name]">
					<option v-for="option in field.options">{{ option }}</option>
				</select>
			</div>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			typeSchema: {},
			loaded: false
		}
	},

	props: ['item', 'offerType'],

	created () {
		this.get()
	},

	methods: {
		get () {
			this.$http.get('setting/type_schema/item').then(response => {
				this.$set('typeSchema', response.data)
				this.loaded = true
			})
		}
	}
}
</script>