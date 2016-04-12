<template>
<div>
	<b>{{ label }}</b>
	<hr>
	<div class="form-group">
		<label class="col-md-4 control-label">
			First Name
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="first_name" placeholder="*"
				v-model="info.first_name"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Last Name
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="last_name" placeholder="*"
				v-model="info.last_name"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Company
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="company"
				v-model="info.company"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Country
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="country"
				v-model="info.country"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Zip
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="zip"
				v-model="info.zip"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			State
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="state"
				v-model="info.state"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			City
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="city"
				v-model="info.city"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Street Address
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="street_address_first"
				v-model="info.street_address_first"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="street_address_second"
				v-model="info.street_address_second"
				:disabled="disabled">
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">
			Apt
		</label>
		<div class="col-md-8">
			<input type="text" maxlength="255" class="form-control" id="apt"
				v-model="info.apt"
				:disabled="disabled">
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	props: ['info', 'label', 'disabled']
}
</script>