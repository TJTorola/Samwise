// libraries
var Vue = 					require('vue')
var Vuex = 					require('vuex')
var VueRouter = 		require('vue-router')
var VueResource = 	require('vue-resource')
var App = 					require('./app.vue')

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueResource)

// Vue-directives
Vue.directive('mask', require('./directives/mask.js'))

// Vue-filters
Vue.filter('displayFormat', require('./filters/displayFormat.js'))
Vue.filter('nl2br', require('./filters/nl2br.js'))

// Set up routing and match routes to components
Vue.http.options.root = '/api';

var router = new VueRouter({
	history: true,
	root: '/admin'
})

router.map(require('./routes.js'))

// Redirect to home route on unmatched route
// TODO: set to user's home
router.redirect({
	'*': '/invoices'
})

router.beforeEach(transition => {
	var app = transition.to.router.app
	app.setPage(transition.to.name, transition.to.description)

	window.scrollTo(0, 0)
	transition.next()
})

Vue.http.interceptors.push(require('./interceptors.js'))

// config Vue global settings
Vue.config.debug = true

// start app on #app div
router.start(App, '#app')