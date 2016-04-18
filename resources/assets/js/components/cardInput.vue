<template>
<div class="input-group" :class="(filled && !luhn)?'has-error':''">
	<span class="input-group-addon"><i class="fa fa-lg" :class="this.cardTypes[this.type].icon"></i></span>

	<input type="text" class="form-control" id="card-number"
		v-mask :mask="this.cardTypes[this.type].mask"
		:mask-input="setNumber">
</div>
</template>

<script>
module.exports = {
	data() {
		return {
			number: '',
			cardTypes: {
				amex: {
					displayName: "American Express",
					icon: "fa-cc-amex",
					mask: "#### ###### #####",
					length: 15,
					iin: "34,37"
				},
				dc: {
					displayName: "Diners Club",
					icon: "fa-cc-diners-club",
					mask: "#### ###### ####",
					length: 14,
					iin: "300-305,309,36,38-39"
				},
				dcusc: {
					displayName: "Diners Club",
					icon: "fa-cc-diners-club",
					mask: "#### #### #### ####",
					length: 16,
					iin: "54,55"
				},
				disc: {
					displayName: "Discover",
					icon: "fa-cc-discover",
					mask: "#### #### #### ####",
					length: 16,
					iin: "6011,622126-622925,644-649,65"
				},
				jcb: {
					displayName: "JCB",
					icon: "fa-cc-jcb",
					mask: "#### #### #### ####",
					length: 16,
					iin: "3528-3589"
				},
				mc: {
					displayName: "Mastercard",
					icon: "fa-cc-mastercard",
					length: 16,
					mask: "#### #### #### ####",
					iin: "51-55"
				},
				visa: {
					displayName: "Visa",
					icon: "fa-cc-visa",
					length: 16,
					mask: "#### #### #### ####",
					iin: "4"
				},
				default: {
					displayName: "Credit",
					icon: "fa-credit-card-alt",
					length: 16,
					mask: "#### #### #### ####"
				}
			}
		}
	},

	computed: {
		type () {
			for (var type in this.cardTypes) {
				if (!this.cardTypes[type].iin) {
					break
				}

				var helper = require('../helper.js')

				var ids = helper.rangesToStrs(this.cardTypes[type].iin)
				for (var i = 0; i < ids.length; i++) {
					if (this.number.startsWith(ids[i])) {
						return type
					}
				}
			}

			return "default"
		},

		luhn () {
			var 
					length = this.number.length,
					doubled = [0, 2, 4, 6, 8, 1, 3, 5, 7, 9],
					bit = 1,
					sum = 0,
					val

			while (length) {
				val = parseInt(this.number.charAt(--length), 10)
				sum += (bit ^= 1) ? doubled[val] : val
			}

			return sum && sum % 10 === 0
		},

		filled () {
			return this.number.length == this.cardTypes[this.type].length
		}
	},

	methods: {
		setNumber (number) {
			this.number = number.split(' ').join('')
		}
	}
}
</script>