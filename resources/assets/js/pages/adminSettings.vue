<template>
<div class="row">
	<div class="col-md-6">
		<register-user></register-user>
	</div>

	<div class="col-md-6">
		<user-privileges></user-privileges>
	</div>
</div>
</template>

<script>
module.exports = {
	components: {
		registerUser: require('app/components/adminSettings/registerUser/box.vue'),
		userPrivileges: require('app/components/adminSettings/userPrivileges/box.vue')
	}
}
</script>