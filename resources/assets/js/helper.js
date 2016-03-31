module.exports = {
	makeSlug (name) {
		return name.toLowerCase().replace(/ |\//g, '-').replace('&', 'and').replace(/[:',]/g, '')
	},

	testName (name) {
		return RegExp(/[^A-Za-z0-9-._~ &:,'\/]/).test(name)
	}
}