module.exports = function(input) {
	input = input.split('_')

	for (var i = 0; i < input.length; i++) {
		input[i] = input[i].charAt(0).toUpperCase() + input[i].slice(1)
	}

	return input.join(' ')
}