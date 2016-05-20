<template>
<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title"><i class="fa fa-user"></i> Register User</h3>

		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<div class="box-body">
		<form class="col-xs-12 form-horizontal">
			<div class="form-group">
				<label for="newName" class="col-sm-4 control-label">Name:</label>
				<div class="col-sm-8">
					<input type="name" maxlength="255" class="form-control" name="newName" v-model="name" required>
				</div>
			</div>

			<div class="form-group">
				<label for="newEmail" class="col-sm-4 control-label">E-Mail:</label>
				<div class="col-sm-8">
					<input type="email" maxlength="255" class="form-control" name="newEmail" v-model="email" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="newPassword" class="col-sm-4 control-label">Password:</label>
				<div class="col-sm-8">
					<input type="password" maxlength="255" class="form-control" name="newPassword" v-model="password" required>
				</div>
			</div>
			
			<div class="form-group">
				<label for="newPasswordConfirmation" class="col-sm-4 control-label">Password Confirmation:</label>
				<div class="col-sm-8">
					<input type="password" maxlength="255" class="form-control" name="newPasswordConfirmation" v-model="passwordConfirmation" required>
				</div>
			</div>

			<div class="btn btn-sm btn-block btn-primary" @click="register">
				<status-icon icon="fa-plus" v-ref:register></status-icon> Register User
			</div>
		</form>
	</div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			name: '',
			email: '',
			password: '',
			passwordConfirmation: ''
		}
	},

	components: {
		statusIcon: require('app/components/statusIcon.vue')
	},

	methods: {
		register () {
			this.$refs.register.working()

			var request = {
				name: this.name,
				email: this.email,
				password: this.password,
				password_confirmation: this.passwordConfirmation
			}

			this.$http.post('auth/register', request).then(response => {
				console.log(response)
				this.$refs.register.check()
			}, () => {
				this.$refs.register.fail()
			})
		}
	}
}
</script>