<template>
<div class="lightbox-mask" v-show="show" transition="lightbox">
	<div class="lightbox-wrapper">
		<div class="lightbox-container">
			<div class="lightbox-header">
				<i class="fa fa-credit-card"></i> Charge Invoice<br>
				<i class="u-thin">Use stripe to charge this invoice to a credit card.</i>
			</div>

			<div class="lightbox-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="card-number" class="col-sm-4 control-label">Card Number:</label>
						<div class="col-sm-8">
							<card-input :number.sync="cardNumber"></card-input>
						</div>
					</div>

					<div class="form-group">
						<label for="cvc" class="col-sm-4 control-label">CVC:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="cvc" v-model="cvc">
						</div>
					</div>

					<div class="form-group">
						<label for="exp" class="col-sm-4 control-label">Experation Date:</label>
						<div class="col-sm-4">
							<select class="form-control" v-model="month">
								<option value='1'>01 - January</option>
								<option value='2'>02 - February</option>
								<option value='3'>03 - March</option>
								<option value='4'>04 - April</option>
								<option value='5'>05 - May</option>
								<option value='6'>06 - June</option>
								<option value='7'>07 - July</option>
								<option value='8'>08 - August</option>
								<option value='9'>09 - September</option>
								<option value='10'>10 - October</option>
								<option value='11'>11 - November</option>
								<option value='12'>12 - December</option>
							</select>
						</div>
						<div class="col-sm-4">
							<select class="form-control" v-model="year">
								<option v-for="n in 10">{{ thisYear + n }}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="card-number" class="col-sm-4 control-label">Zip:</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="card-number" v-model="zip">
						</div>
					</div>
				</form>
			</div>

			<div class="lightbox-footer">
				<slot name="footer">
					<button class="btn btn-sm btn-primary"
						:disabled="charging || (total <= 0)"
						@click="charge">
						<status-icon icon="fa-credit-card" v-ref:status></status-icon>
						<b v-if='total >= 0'> ({{ total / 100 | currency }})</b>
						<b v-else> (...)</b> Submit Charge
					</button>
					<button class="btn btn-sm pull-right" @click="show = false" :disabled="charging">
						<i class="fa fa-times"></i> Cancel Charge
					</button>
				</slot>
			</div>
		</div>
	</div>
</div>
</template>

<script>
module.exports = {
	data: function() {
		return {
			cardNumber: "",
			cvc: "",
			year: new Date().getFullYear(),
			zip: 0,
			month: 1,
			charging: false,
			total: -1
		}
	},

	props: {
		id: {
			type: Number
		},

		show: {
			type: Boolean,
			required: true,
			twoWay: true
		}
	},

	components: {
		statusIcon: require('app/components/statusIcon.vue'),
		cardInput: require('./cardInput.vue')
	},

	watch: {
		show () {
			if (this.show) {
				this.total = 0
				this.getInvoice()
			}
		}
	},

	created () {
		// init stripe
		this.$nextTick(function() {
			Stripe.setPublishableKey(this.publicKey)
		})
	},

	computed: {
		thisYear () {
			return new Date().getFullYear()
		},

		publicKey () {
			return $('#stripe-key-public').attr('content')
		}
	},

	methods: {
		charge () {
			this.charging = true
			this.$refs.status.working()

			var cardInfo = {
				number: this.cardNumber,
				cvc: this.cvc,
				exp_month: this.month,
				exp_year: this.year,
				address_zip: this.zip
			}

			var token = Stripe.card.createToken(cardInfo, function(status, response) {
				if (response.error) {
					this.$root.notify('danger', 'Error', response.error.message)

					this.charging = false
					this.$refs.status.fail()
					return
				}

				var request = {
					token: response,
					amount: this.total
				}

				this.$http.post(`/api/invoice/${this.id}/payment`, request).then(function(response) {
					this.charging = false
					this.$root.notify('info', 'Charged', 'The invoice was successfully charged.', 3)
					this.number = ""
					this.cvc = ""
					this.exp_month = 1
					this.exp_year = this.thisYear
					this.show = false

					this.$dispatch('PAID', response.data.amount)


					this.$refs.status.check()
				}, function() {
					this.charging = false
					this.$refs.status.fail()
				})
			}.bind(this))
		},

		getInvoice () {
			this.$http.get(`/api/invoice/${this.id}`).then(function(response) {
				var data = response.data
				this.total = data.due
				this.zip = (data.seperate_billing) ? data.billing_address.zip : data.shipping_address.zip
			})
		}
	},
}
</script>