module.exports = {
	// construct the object
	bind () {
		this.rtl = (this.arg == 'rtl')
		this.mask = this.expression.split('')

		this.el.addEventListener('keydown', this.keydown.bind(this))
		this.el.addEventListener('keypress', this.keypress.bind(this))
		this.el.addEventListener('keyup', this.keyup.bind(this))
		this.el.addEventListener('paste', this.paste.bind(this))
	},

	// deconstruct the object
	unbind () {
		this.el.removeEventListener('keydown', this.keydown)
		this.el.removeEventListener('keypress', this.keypress)
		this.el.removeEventListener('keyup', this.keyup)
		this.el.removeEventListener('paste', this.paste)
	},

	// record the state, and handle backspace
	keydown (e) {
		this.recordState(e)
		if (this.is_backspace) {
			e.preventDefault()

			if (this.start != this.end) {
				this.collapseSelection()
				this.removeMask()
				this.applyMask()
				this.applyState()
			} else {
				this.collapseSelection()
				this.removeMask()
				this.backspace()
				this.applyMask()
				this.applyState()
			}
		}
	},

	// prevent events
	keypress (e) {
		e.preventDefault()
	},

	// handle char entry
	keyup (e) {
		this.recordState(e)

		if (this.is_numeric) {
			this.collapseSelection()
			if (this.value.length > this.mask.length) {
				this.removeMask()
				this.applyMask()
				this.applyState()
				return
			}

			this.removeMask()
			this.addChar()
			this.applyMask()
			this.applyState()
		}
	},

	paste (e) {
		setTimeout(function() {
			this.recordState(e)
			this.removeMask()
			this.applyMask()
			this.applyState()
		}.bind(this))
	},

	recordState(e) {
		this.start = this.el.selectionStart
		this.end = this.el.selectionEnd

		this.value = this.el.value.split('')
		this.kcode = e.keyCode
		this.char = String.fromCharCode(this.kcode)
		this.is_numeric = !isNaN(parseInt(this.char))
		this.is_backspace = (this.kcode == 8)

		// place the caret position in the value array
		this.value.splice(this.start, 0, 'caret')
		this.value.splice(this.end + 1, 0, 'end')
	},

	applyState() {
		var caret = this.value.indexOf("caret")
		this.value.splice(caret, 1)

		this.el.value = this.value.join('')
		this.el.selectionStart = caret
		this.el.selectionEnd = caret
	},

	// merge selectionStart & selectionEnd, destroying all chars in between them
	collapseSelection() {
		var i = this.value.indexOf("caret") + 1

		// keep removing chars until we find the end
		while (this.value[i] != 'end') {
			this.value.splice(i, 1)
		}

		// remove the end
		this.value.splice(i, 1)
	},

	// add a char at the caret
	addChar(char = null) {
		var i = this.value.indexOf("caret")
		if (char == null) {
			this.value.splice(i, 0, this.char)
		} else {
			this.value.splice(i, 0, char)
		}
	},

	// remove char before caret
	backspace() {
		var i = this.value.indexOf("caret")
		if (i > 0) {
			this.value.splice(i - 1, 1)
		}
	},

	// remove all non numeric chars from array (except caret)
	removeMask() {
		for (var i = this.value.length - 1; i >= 0; i--) {
			if (isNaN(parseInt(this.value[i])) && this.value[i] != 'caret') {
				this.value.splice(i, 1)
			}
		}
	},

	applyMask() {
		var maskedValue = []

		var i = 0
		if (this.rtl) {
			this.mask.reverse()
			this.value.reverse()
		}

		if (this.value[0] == 'caret') {
			maskedValue.push(this.value.shift())
		}

		while (this.value.length > 0) {
			if (i > this.mask.length) {
				break
			}

			if (this.mask[i] == '#') {
				maskedValue.push(this.value.shift())
				if (this.value[0] == 'caret') {
					maskedValue.push(this.value.shift())
				}
			} else {
				maskedValue.push(this.mask[i])
			}
			i++
		}

		if (this.rtl) {
			this.mask.reverse()
			maskedValue.reverse()
		}

		this.value = maskedValue
	}
}