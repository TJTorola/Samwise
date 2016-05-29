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

module.exports = {
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
}