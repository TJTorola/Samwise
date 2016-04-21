<template>
<div v-else class="login-form">
	<div class="input-wrapper">
		<span class='fa fa-envelope'></span>
		<input type='text' name='email' placeholder="E-Mail" 
			v-model="email"
			@enter="postLogin">
	</div>

	<div class="input-wrapper">
		<span class='fa fa-key'></span>
		<input type='password' name='password' placeholder="*******" id="password" 
			v-model="password"
			@enter="postLogin">
	</div>

	<div class="submit-placeholder" v-if="!validLogin">
		<status-icon icon="fa-sign-in" v-ref:login-status></status-icon> ENTER VALID {{ (validEmail)?'PASSWORD':'EMAIL' }}
	</div>
	<div @click="postLogin" class="submit-button u-unselectable" v-else>
		<status-icon icon="fa-sign-in" v-ref:login-status></status-icon> SUBMIT LOGIN
	</div>

	<div class="g-recaptcha" data-sitekey="{{ recaptchaKey }}" v-if="captchaRequired"></div>
</div>
</template>

<script>
module.exports = {
	data () {
		return {
			email: "",
			password: "",
			captchaRequired: false,
			recaptchaKey: $('#key-recaptcha').attr('content')
		}
	},

	components: {
		statusIcon: require('./statusIcon.vue')
	},

	computed: {
		validEmail () {
			var regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
			return regex.test(this.email)
		},
		validPassword () {
			return this.password.length >= 8
		},
		validLogin () {
			return this.validEmail && this.validPassword
		}
	},

	methods: {
		postLogin () {
			if (this.captchaRequired) {
				var captcha = grecaptcha.getResponse()

				if (!captcha) {
					this.notify('warning', 'Captcha Required', 'Please indicate that you are not a robot.', 3000)
					return
				}
			} else {
				captcha = null
			}

			this.$refs.loginStatus.working()

			var request = {
				email: this.email,
				password: this.password,
				captcha: captcha
			}

			this.$http.post('auth', request).then(function(response) {
				// reset authentication credentials
				this.password = ""
				this.email = ""
				this.captchaRequired = false

				// append the auth token to all http further requests
				var Vue = require('vue')
				Vue.http.headers.common['Authorization'] = 'Bearer ' + response.data.token

				// set auth token and grab the logged in user data
				this.setAuthentication(response.data)
				this.getUser()

				this.$refs.loginStatus.check()
			}, function(response) {
				this.$refs.loginStatus.fail()
			})
		},

		resetCaptcha () {
			if (this.captchaRequired) {
				grecaptcha.reset()
			} else {
				this.captchaRequired = true
				this.$nextTick(function() {
					grecaptcha.render($('.g-recaptcha')[0], { sitekey : this.recaptchaKey })
				})
			}
		},
	},

	vuex: {
		getters: {
			user: state => state.user
		},

		actions: require('app/vuex/actions/user.js')
	}
}
</script>