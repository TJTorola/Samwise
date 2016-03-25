module.exports = {
	// model -> view
  // formats the value when updating the input element.
  read (val) {
    return '$'+val
  },
  
  // view -> model
  // formats the value when writing to the data.
  write (val, oldVal) {
    var number = +val.replace(/[^\d.]/g, '')
    return isNaN(number) ? 0 : parseFloat(number.toFixed(2))
  }
}