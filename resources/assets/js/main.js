// libraries
var Vue = 					require('vue')
var Vuex = 					require('vuex')
var VueRouter = 		require('vue-router')
var VueResource = 	require('vue-resource')
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueResource)

Vue.http.options.root = '/api';

Vue.directive('mask', require('./directives/mask.js'))

// Vue-filters
Vue.filter('displayFormat', require('./filters/displayFormat.js'))
Vue.filter('nl2br', require('./filters/nl2br.js'))

// Vue-pages
var App = 					require('./app.vue')
// var FileNotFound =	require('./pages/404.vue')
// var ServerError =		require('./pages/500.vue')
var Invoice = 			require('./pages/invoice.vue')
var Invoices = 			require('./pages/invoices.vue')
var NewInvoice = 		require('./pages/newInvoice.vue')
var Offers = 				require('./pages/offers.vue')
var Offer = 				require('./pages/offer.vue')
var NewOffer = 			require('./pages/newOffer.vue')
var Pages = 				require('./pages/pages.vue')
// var Page = 					require('./pages/page.vue')
var Catalogs = 			require('./pages/catalogs.vue')
var Catalog = 			require('./pages/catalog.vue')
// var MySettings = 		require('./pages/mysettings.vue')
var AdminSettings = require('./pages/adminSettings.vue')
// var StoreSettings = require('./pages/storesettings.vue')
// var Log = 					require('./pages/log.vue')

// Set up routing and match routes to components
var router = new VueRouter({
	history: true,
	root: '/admin'
})

router.map({
	// // Error Pages
	// '/404': {
	// 	component: FileNotFound
	// },
	// '/500': {
	// 	component: ServerError
	// },
	// Resources
	'/invoice/:id': {
		name: 'Invoice',
		description: 'Modify existing customer invoices.',
		component: Invoice
	},
	'/invoices': {
		name: 'Invoices',
		description: 'Browse/Search customer invoices.',
		component: Invoices
	},
	'/new-invoice': {
		name: 'New Invoice',
		description: 'Create a new Invoice (Customer won\'t get emailed automatically).',
		component: NewInvoice
	},
	'/offers': {
		name: 'Offers',
		description: 'Search your Inventory, or create new offers.',
		component: Offers
	},
	'/offer/:id': {
		name: 'Offer',
		description: 'An offer is comprised of an item or multiple similar items to be purchased.',
		component: Offer
	},
	'/new-offer': {
		name: 'New Offer',
		description: 'Offer a new item or collection of items on your store.',
		component: NewOffer
	},
	'/pages': {
		name: 'Pages',
		description: 'Pages allow for static content on your website.',
		component: Pages
	},
	// '/page/:id': {
	// 	name: 'Page',
	// 	component: Page
	// },
	'/catalogs': {
		name: 'Catalogs',
		description: 'Catalogs collect many similar offers into one section of your storefront.',
		component: Catalogs
	},
	'/catalog/:id': {
		name: 'Catalog',
		description: 'A catalog collects offers based on their tags.',
		component: Catalog
	},
	// // Settings
	// '/mysettings': {
	// 	name: 'MySettings',
	// 	component: MySettings
	// },
	'/admin-settings': {
		name: 'Adminstrative Settings',
		description: 'Set Global Control Panel Settings and Users.',
		component: AdminSettings
	},
	// '/storesettings': {
	// 	name: 'StoreSettings',
	// 	component: StoreSettings
	// },
	// '/log': {
	// 	name: 'Log',
	// 	component: Log
	// },
})

// Redirect to home route on unmatched route
// TODO: set to user's home
router.redirect({
	'*': '/invoices'
})

router.beforeEach(function (transition) {
	var app = transition.to.router.app
	app.setPage(transition.to.name, transition.to.description)

	window.scrollTo(0, 0)
	transition.next()
})

Vue.http.interceptors.push({
	response (response) {
		if (response.data.note) {
			var note = response.data.note
			this.$root.notify(note.type, note.title, note.body, note.timeout)
		}

		if (response.status == 404) {
			this.$root.notify('danger', 'Not Found', 'The requested resource was not found.')
		}

		if (response.status == 422) {
			for(var title in response.data) {
				this.$root.notify('danger', title, response.data[title])
			}
		}

		// if (response.status == 200) {
		// 	if (response.request.url == "auth") {
		// 		this.password = ""
		// 		this.email = ""
		// 		this.captchaRequired = false
		// 		Vue.http.headers.common['Authorization'] = 'Bearer ' + response.data.token
		// 		this.login()
		// 	}
		// }

		if (response.status == 400) {
			if (typeof response.data.attempts_remaining == 'number' && response.data.attempts_remaining <= 0) {
				this.$root.$refs.login.resetCaptcha()
			}
		}

		if (response.status == 401) {
			this.$root.logout()
		}

		if (response.status == 429) {
			this.$root.$refs.login.resetCaptcha()
		}

		return response
	}
})

// config Vue global settings
Vue.config.debug = true

// start app on #app div
router.start(App, '#app')
