const frontZeros = (input, length) => {
	if ((input).toString().length >= length) return input;
	return frontZeros(`0${ input }`, length);
}

module.exports = frontZeros;