module.exports = {
	makeSlug (name) {
		return name.toLowerCase().replace(/ |\//g, '-').replace('&', 'and').replace(/[:',]/g, '')
	},

	testName (name) {
		return RegExp(/[^A-Za-z0-9-._~ &:,'\/]/).test(name)
	},

	strRange(start, stop) {
		var i = parseInt(start)
		var range = []

		while (i <= parseInt(stop)) {
			// console.log(i)
			range.push(i.toString())
			i++
		}

		return range
	},

	rangesToStrs(str) {
		var strings = []

		str.split(',').forEach(range => {
			var limits = range.split('-')
			if (limits.length == 1) {
				strings.push(limits[0])
			}

			strings.concat(this.strRange(limits[0], limits[1]))
		})

		return strings
	}
}