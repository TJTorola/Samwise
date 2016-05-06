<template>
<div class='box box-primary'> <!-- Type Info -->
	<div class='box-header'>
		<h3 class='box-title'><i class="fa fa-info"></i> Type Info</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>

	<div class="box-body" v-if="loaded">
		<div class="box-group" id="accordion">

			<div class="panel box box-accordion" v-for="section in typeSchema[offer.type]">

				<div class="box-header with-border">
					<h4 class="box-title">
						<a data-toggle="collapse" data-parent="#accordion" v-bind:href="'#collapse'+$key">
							{{ $key }}
						</a>
					</h4>
				</div>
				<div v-bind:id="'collapse'+$key" class="panel-collapse collapse" v-bind:class="($index == 0) ? 'in' : ''">
					<div class="box-body">

						<div class="col-xs-12" v-for="field in section">
							<div class="form-group">
								<div v-if="field.type == 'string'">
									<label for="{{ field.name }}" class="col-sm-12">
										<span v-if="field.display_name">{{ field.display_name }}:</span>
										<span v-else>{{ field.name | displayFormat }}:</span>
										<small v-if="field.hint"> {{ field.hint }}</small>
									</label>
									<div class="col-sm-12">
										<input type="name" maxlength="255" class="form-control" id="{{ field.name }}" v-model="offer[field.name]">
									</div>
								</div>

								<div v-if="field.type == 'boolean'">
									<div class="col-sm-12">
										<div class="checkbox">
											<label for="{{ field.name }}">
												<input type="checkbox" id="{{ field.name }}" v-model="offer[field.name]">
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
									<label for="{{ field.name }}" class="col-sm-12">
										<span v-if="field.display_name">{{ field.display_name }}:</span>
										<span v-else>{{ field.name | displayFormat }}:</span>
										<small v-if="field.hint"> {{ field.hint }}</small>
									</label>
									<div class="col-sm-12">
										<select class="form-control" id="{{ field.name }}" v-model="offer[field.name]">
											<option v-for="option in field.options">{{ option }}</option>
										</select>
									</div>
								</div>
							</div>
						</div> <!-- END FIELD -->

					</div>
				</div>
			</div> <!-- END SECTION -->

		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			loaded: false,
			typeSchema: {}
		}
	},

	created () {
		this.get()
	},

	props: ['offer'],

	methods: {
		get () {
			this.$http.get('setting/type_schema/offer').then(response => {
				this.loaded = true
				this.$set('typeSchema', response.data)
			})
		}
	}
}
</script>