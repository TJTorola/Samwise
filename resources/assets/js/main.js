// libraries
var Vue = 					require('vue')
var Vuex = 					require('vuex')
var VueRouter = 		require('vue-router')
var VueResource = 	require('vue-resource')
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueResource)

Vue.http.options.root = '/api';

// Vue-filters
// var nl2br = 				require('./filters/nl2br.js')
// var displayFormat = require('./filters/display-format.js')
// Vue.filter('nl2br', nl2br)
// Vue.filter('displayFormat', displayFormat)

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
var Inventory = 		require('./pages/inventory.vue')
var Item = 					require('./pages/item.vue')
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
		description: 'Browse Customer Invoices',
		component: Invoices
	},
	'/newinvoice': {
		name: 'NewInvoice',
		description: 'Create an Invoice',
		component: NewInvoice
	},
	'/invoice/:id': {
		name: 'Invoice',
		description: '',
		component: Invoice
	},
	'/printInvoice/:id': {
		name: 'PrintInvoice',
		description: 'Print the Invoice',
		component: PrintInvoice
	},
	'/inventory': {
		name: 'Inventory',
		description: 'Search your Items',
		component: Inventory
	},
	'/item/:id': {
		name: 'Item',
		description: '',
		component: Item
	},
	'/pages': {
		name: 'Pages',
		description: 'Sort your Pages',
		component: Pages
	},
	// '/page/:id': {
	// 	name: 'Page',
	// 	component: Page
	// },
	'/catalogs': {
		name: 'Catalogs',
		description: 'Sort your Catalogs',
		component: Catalogs
	},
	'/catalog/:id': {
		name: 'Catalog',
		description: '',
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
		name: 'AdminSettings',
		description: 'Adminstrate your Website',
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
	request: function (request) {
		return request
	},

	response (response) {
		if (response.status == 200) {
			if (response.request.url == "auth") {
				this.password = ""
				this.email = ""
				Vue.http.headers.common['Authorization'] = 'Bearer ' + response.data.token
				this.login()
			}
		}

		if (response.status == 400) {
			this.notify('warning', 'Invalid Credentials', response.data)
		}

		if (response.status == 401) {
			unset(Vue.http.headers.common['Authorization'])
			this.logout()
		}



		return response
	}
})

// config Vue global settings
Vue.config.debug = true

// start app on #app div
router.start(App, '#app')
