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
// Vue.filter('mask', require('./filters/mask.js'))
Vue.filter('nl2br', require('./filters/nl2br.js'))

// preloaded stores
// var page = require('./store/page.js')
// var status = require('./store/notifications.js')
// var user = require('./store/user.js')

// Vue-pages
var App = 					require('./app.vue')
// var FileNotFound =	require('./pages/404.vue')
// var ServerError =		require('./pages/500.vue')
var Invoices = 			require('./pages/invoices.vue')
var Invoice = 			require('./pages/invoice.vue')
var NewInvoice = 		require('./pages/newinvoice.vue')
var PrintInvoice = 	require('./pages/printinvoice.vue')
var Offers = 				require('./pages/offers.vue')
var Offer = 				require('./pages/offer.vue')
var Pages = 				require('./pages/pages.vue')
// var Page = 					require('./pages/page.vue')
var Catalogs = 			require('./pages/catalogs.vue')
var Catalog = 			require('./pages/catalog.vue')
// var Customers = 		require('./pages/customers.vue')
// var Customer = 			require('./pages/customer.vue')
// var Statistics = 		require('./pages/statistics.vue')
// var Calendar = 			require('./pages/calendar.vue')
// var Messages = 			require('./pages/messages.vue')
// var Users = 				require('./pages/users.vue')
// var User = 					require('./pages/user.vue')
// var MySettings = 		require('./pages/mysettings.vue')
var AdminSettings = require('./pages/adminsettings.vue')
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
	'/invoice/:id': {
		name: 'Invoice',
		description: 'Invoices are orders made by customers or control panel users.',
		component: Invoice
	},
	'/print-invoice/:id': {
		name: 'Print Invoice',
		description: 'Print the Invoice',
		component: PrintInvoice
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
	// '/customers': {
	// 	name: 'Customers',
	// 	component: Customers
	// },
	// '/customer/:id': {
	// 	name: 'Customer',
	// 	component: Customer
	// },
	// // User Tools
	// '/statistics': {
	// 	name: 'Statistics',
	// 	component: Statistics
	// },
	// '/calendar': {
	// 	name: 'Calendar',
	// 	component: Calendar
	// },
	// '/messages': {
	// 	name: 'Messages',
	// 	component: Messages
	// },
	// '/users': {
	// 	name: 'Users',
	// 	component: Users
	// },
	// '/user/:id': {
	// 	name: 'User',
	// 	component: User
	// },
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
// router.redirect({
// 	'*': '/login'
// })

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
			this.notify(note.type, note.title, note.body, note.timeout)
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
				this.resetCaptcha()
			}
		}

		if (response.status == 401) {
			this.logout()
		}

		if (response.status == 429) {
			this.resetCaptcha()
		}

		return response
	}
})

// config Vue global settings
Vue.config.debug = true

// start app on #app div
router.start(App, '#app')
