<template>
<div class="wrapper">
	<div class="notification-layer">
		<div class="box box-solid" :class="'box-'+notification.type" v-for="notification in notifications" transition="slide-in">
			<div class="box-header with-border">
				<h3 class="box-title" v-if="notification.title">{{ notification.title }}</h3>
				<h3 class="box-title" v-else>{{ notification.type | capitalize }}</h3>
				<div class="box-tools pull-right">
					<button class="btn btn-box-tool" @click="deleteNotification($index)"><i class="fa fa-times"></i></button>
				</div><!-- /.box-tools -->
			</div><!-- /.box-header -->
			<div class="box-body">
				{{{ notification.message }}}
			</div><!-- /.box-body -->
		</div>
	</div>

	<header class="main-header">
		<a v-link="{ path: '/' }" :class="(loggedIn)?'logo':'u-full logo'">
			<!-- mini logo for sidebar mini 50x50 pixels -->
			<!-- // TODO: add variable short titles -->
			<span class="logo-mini"><b>P</b>4x4</span>
			<!-- logo for regular state and mobile devices -->
			<span class="logo-lg"><b>Admin P</b>4x4</span>
		</a>

		<nav class="navbar navbar-static-top" role="navigation" v-if="loggedIn">
			<!-- Sidebar toggle button-->
			<a class="sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
			</a>
			<!-- Navbar Right Menu -->
			<div class="navbar-custom-menu">
				<ul class="nav navbar-nav">

					<!-- Messages: style can be found in dropdown.less-->
					<li class="dropdown messages-menu">
						<!-- Menu toggle button -->
						<a class="dropdown-toggle" data-toggle="dropdown">
							<i class="fa fa-shopping-cart"></i>
							<span class="label label-warning" v-if="cart.items.length">
								<span class="fa fa-spinner fa-pulse" v-if="cart.working"></span>
								<span v-else>{{ cart.count }}</span>
							</span>
						</a>
						<ul class="dropdown-menu" v-if="!cart.working">
							<li class="header">You have {{ cart.count }} item in your cart.</li>
							<li>
								<!-- <cart></cart> -->
							</li>
							<li>
								<li class="footer"><a href="#/newinvoice">Subtotal: {{ cart.subtotal | currency }} - Add Invoice</a></li>
							</li>
						</ul>
					</li><!-- /cart-menu -->

					<!-- User Account Menu -->
					<li class="dropdown user user-menu">
						<!-- Menu Toggle Button -->
						<a class="dropdown-toggle" data-toggle="dropdown">
							<!-- The user image in the navbar-->
							<img v-bind:src="user.info.gravitar" class="user-image" alt="User Image">
							<!-- hidden-xs hides the username on small devices so only the image appears. -->
							<span class="hidden-xs">{{ user.info.name }}</span>
						</a>
						<ul class="dropdown-menu">
							<!-- The user image in the menu -->
							<li class="user-header">
								<img v-bind:src="user.info.gravitar" class="img-circle" alt="User Image">
								<p>
									{{ user.info.name }}
									<small>Member since {{ user.info.created_at }}</small>
								</p>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="javascript:;" class="btn btn-default btn-flat js-link" data-href="/user">Profile</a>
								</div>
								<div class="pull-right">
									<a href="javascript:;" @click="logout" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
					<!-- Control Sidebar Toggle Button -->
					<li>
						<a data-toggle="control-sidebar"><i class="fa fa-check-square-o"></i></a>
					</li>
				</ul>
			</div>
		</nav>
	</header>

	<aside class="main-sidebar" v-if=loggedIn>

		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">

			<!-- Sidebar user panel (optional) -->
			<div class="user-panel">
				<div class="pull-left image">
					<img v-bind:src="user.info.gravitar" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p>{{ user.info.name }}</p>
					<!-- Status -->
					<small><i class="fa fa-circle text-success"></i> Online</small>
				</div>
			</div>

			<!-- search form -->
			<div class="input-group isSearch">
					<input type="text" class="form-control grayFade-input" placeholder="Search...">
					<span class="input-group-addon grayFade-addon">
						<i class="fa fa-search"></i>
					</span>
				</div>
			<!-- /.search form -->

			<!-- Sidebar Menu -->
			<ul class="sidebar-menu">
				<!-- invoices inventory pages catalogs customers -->
				<li class="header" v-if="user.info.invoices || user.info.inventory || user.info.pages || user.info.catalogs || user.info.customers">Resources</li>

				<li class="js-link" v-if="user.info.invoices">
					<a v-link="{ path: '/invoices' }">
						<i class="fa fa-credit-card"></i> <span>Invoices</span>
						<small class="label pull-right label-danger" v-if="status.invoices">{{ status.invoices }}</small>
					</a>
				</li>

				<li class="js-link" v-if="user.info.inventory">
					<a v-link="{ path: '/inventory' }">
						<i class="fa fa-archive"></i> <span>Inventory</span>
					</a>
				</li>

				<li class="js-link" v-if="user.info.pages">
					<a v-link="{ path: '/pages' }">
						<i class="fa fa-file-text"></i> <span>Pages</span>
					</a>
				</li>

				<li class="js-link" v-if="user.info.catalogs">
					<a v-link="{ path: '/catalogs' }">
						<i class="fa fa-list-alt"></i> <span>Catalogs</span>
					</a>
				</li>

				<!-- <li class="js-link" v-if="user.info.customers">
					<a v-link="{ path: '/customers' }">
						<i class="fa fa-users"></i> <span>Customers</span>
					</a>
				</li> -->

				<!-- <li class="header">User Tools</li>

				<li class="js-link">
					<a v-link="{ path: '/statistics' }">
						<i class="fa fa-bar-chart"></i> <span>Site Statistics</span>
					</a>
				</li>

				<li class="js-link">
					<a v-link="{ path: '/calendar' }">
						<i class="fa fa-calendar"></i> <span>Calendar</span>
						<small class="label pull-right label-success">{{ status.events }}</small>
					</a>
				</li>

				<li class="js-link">
					<a v-link="{ path: '/messages' }">
						<i class="fa fa-inbox"></i> <span>Messages</span>
						<small class="label pull-right label-warning">{{ status.messages }}</small>
					</a>
				</li>

				<li class="js-link">
					<a v-link="{ path: '/users' }">
						<i class="fa fa-user-md"></i> <span>Staff</span>
					</a>
				</li> -->

				<li class="header" v-if="user.info.admin">Settings</li>

				<!-- <li class="js-link">
					<a v-link="{ path: '/mysettings' }">
						<i class="fa fa-cog"></i> <span>My Settings</span>
					</a>
				</li> -->

				<li class="js-link" v-if="user.info.admin">
					<a v-link="{ path: '/admin-settings' }">
						<i class="fa fa-cogs"></i> <span>Admin Settings</span>
					</a>
				</li>

				<!-- <li class="js-link" v-if="user.info.admin">
					<a v-link="{ path: '/storesettings' }">
						<i class="fa fa-wrench"></i> <span>Store Settings</span>
					</a>
				</li>

				<li class="js-link" v-if="user.info.admin">
					<a v-link="{ path: '/log' }">
						<i class="fa fa-list"></i> <span>Log</span>
					</a>
				</li> -->

			</ul><!-- /.sidebar-menu -->
		</section>
		<!-- /.sidebar -->
	</aside>

	<div class="page">
		<!-- Content Wrapper. Contains page content -->
		<div id="vue-page" :class="(loggedIn)?'content-wrapper':'u-no-margin content-wrapper'">

			<!-- Content Header (Page header) -->
			<section class="content-header" v-if="loggedIn">
				<h1>
					<span class="fa fa-home"></span>
					{{ page.name }}
					<small>{{ page.description }}</small>
				</h1>
				<ol class="breadcrumb">
					<!-- <li><a href="javascript:;" onclick="renderPage('<?=$crumb['link']?>');"><?=$crumb['name']?></a></li> -->
					<li class="active">{{ page.name }}</li>
				</ol>
			</section>

			<section class='content'>

				<router-view v-if="loggedIn"></router-view>

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
					<div @click="postLogin" class="submit-button" v-else>
						<status-icon icon="fa-sign-in" v-ref:login-status></status-icon> SUBMIT LOGIN
					</div>

					<div class="g-recaptcha" data-sitekey="{{ recaptchaKey }}" v-if="captchaRequired"></div>
				</div>

			</section>
		</div><!-- /.content-wrapper -->
	</div>

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Create the tabs -->
		<ul class="nav nav-tabs nav-justified control-sidebar-tabs">
			<li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-check-square-o"></i></a></li>
			<li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-list"></i></a></li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<!-- Home tab content -->
			<div class="tab-pane active" id="control-sidebar-home-tab">
				<h3 class="control-sidebar-heading">Todo List:</h3>

				<div class="input-group">
					<input type="text" class="form-control grayFade-input" placeholder="I need to..." v-model="user.info.newTodo" v-on:keyup.enter="storeTodo">
					<span class="input-group-addon grayFade-addon" v-on:click="storeTodo">
						<i class="fa fa-thumb-tack"></i>
					</span>
				</div>

				<br>

				<ul class="control-sidebar-menu">
					<li v-for="todo in user.info.todos">
						<a class="task-link" v-on:click="deleteTodo($index)">
							<i class="menu-icon fa fa-square-o bg-red"></i>
							<i class="menu-icon fa fa-check-square-o bg-red"></i>
							<div class="menu-info">
								<h4 class="control-sidebar-subheading">{{ todo.task }}</h4>
								<p>{{ todo.created_at }}</p>
							</div>
						</a>
					</li>
				</ul><!-- /.control-sidebar-menu -->

			</div><!-- /.tab-pane -->
			<!-- Settings tab content -->
			<div class="tab-pane" id="control-sidebar-settings-tab">
				<h3 class="control-sidebar-heading">Event Log:</h3>
				Under Construction
			</div><!-- /.tab-pane -->
		</div>
	</aside><!-- /.control-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg"></div>

</div>
</template>

<script>
var store = require('./vuex/store.js')
var actions = require('./vuex/actions.js')

module.exports = {
	data () {
		return {
			email: "",
			password: "",
			captchaRequired: false,
			recaptchaKey: $('#key-recaptcha').attr('content')
		}
	},

	computed: {
		loggedIn () {
			return Boolean(this.user.info.name)
		},
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

	components: {
		statusIcon: require('./components/statusIcon.vue')
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

				// activate newly revealed adminLTE controls
				this.$nextTick(function() {
					$.AdminLTE.pushMenu.activate("[data-toggle='offcanvas']")
					$.AdminLTE.controlSidebar.activate()
				})

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

		storeTodo () {}
	},

	store,

	vuex: {
		getters: {
			notifications: state => state.notifications,
			status: state => state.status,
			user: state => state.user,
			cart: state => state.cart, 
			page: state => state.page
		},
		actions
	}
}
</script>
