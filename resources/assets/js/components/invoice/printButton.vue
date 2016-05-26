<template>
<span>
	<button class="btn btn-sm btn-block btn-primary" @click="print">
		<i class="fa fa-print"></i> Print
	</button>

	<div class="print-area">
		<div class="row">
			<div class="col-xs-6">
				<img src="/img/store/webLogoOutlined.svg" class="img-responsive">
			</div>
			<div class="col-xs-6">
				<table class="print-table" style='float:right;'>
					<tr>
						<td style='width:2in;'>Invoice No.</td>
						<td style='width:2in;'>INV{{ invoice.id }}</td>
					</tr>
					<tr>
						<td>Date</td>
						<td>{{ invoice.created_at }}</td>
					</tr>
				</table>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-xs-6" v-if="invoice.seperate_billing">
				<b>Ship To:</b><br>
				{{ invoice.first_name }} {{ invoice.last_name }} <span v-if="invoice.company">of {{ invoice.company }}</span><br>
				{{ invoice.street_address_first }}<br>
				<div v-if="invoice.street_address_second">{{ invoice.street_address_second }}</div>
				<div v-if="invoice.apt">(Apt/Suite/Bld)#{{ invoice.apt }}</div>
				{{ invoice.city }}, {{ invoice.state }}, {{ invoice.country }}<br>
				{{ invoice.zip }}<br><br>
				<b>Bill To:</b><br>
				{{ invoice.billing_first_name }} {{ invoice.billing_last_name }} <span v-if="invoice.billing_company">of {{ invoice.billing_company }}</span><br>
				{{ invoice.billing_street_address_first }}<br>
				<div v-if="invoice.billing_street_address_second">{{ invoice.billing_street_address_second }}</div>
				<div v-if="invoice.billing_apt">(Apt/Suite/Bld)#{{ invoice.billing_apt }}</div>
				{{ invoice.billing_city }}, {{ invoice.billing_state }}, {{ invoice.billing_country }}<br>
				{{ invoice.billing_zip }}
			</div>
			<div class="col-xs-6" v-else>
				<b>Bill/Ship To:</b><br>
				{{ invoice.first_name }} {{ invoice.last_name }} <span v-if="invoice.company">of {{ invoice.company }}</span><br>
				{{ invoice.street_address_first }}<br>
				<div v-if="invoice.street_address_second">{{ invoice.street_address_second }}</div>
				<div v-if="invoice.apt">(Apt/Suite/Bld)#{{ invoice.apt }}</div>
				{{ invoice.city }}, {{ invoice.state }}, {{ invoice.country }}<br>
				{{ invoice.zip }}
			</div>
			<div class="col-xs-6 text-right">
				<b>Pangolin 4x4</b><br>
				1360 Tamarack Street<br>
				Springfield, Oregon<br>
				97477<br>
				541.606.0095
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-xs-12">
				<table class="print-table" style="width:100%;">
					<thead>
						<tr>
							<th style='text-align:left;'>Description</th>
							<th style='width:1in;text-align:center;'>Quantity</th>
							<th style='width:1in;text-align:center;'>Unit Cost</th>
							<th style='width:1in;text-align:right;'>Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="item in invoice.cart.items">
						<td>{{{ item.name | nl2br }}}</td>
							<td>{{ item.count }}</td>
							<td>{{ item.price / 100| currency }}</td>
							<td>{{ (parseFloat(item.count) * parseFloat(item.price)) / 100 | currency }}</td>
						</tr>
					</tbody>
				</table>
				<br>
				<b>Status:</b>
				<span v-if="invoice.shipped">Shipped</span>
				<span v-if="invoice.paid && !invoice.shipped">Paid</span>
				<span v-if="invoice.billed && !invoice.paid && !invoice.shipped">Billed</span>
				<span v-if="!invoice.billed && !invoice.paid && !invoice.shipped">Unbilled</span>
			</div>
		</div>

		<hr>

		<div class="row">
			<div class="col-xs-12">
				<p style='float:right;width:1.2in;text-align:right;'>
					{{ invoice.subtotal / 100 | currency }}<br>
					{{ invoice.shipping_cost / 100 | currency }}<br>
					<br>
					{{ (parseFloat(invoice.subtotal) + parseFloat(invoice.shipping_cost)) / 100 | currency }}
				</p>
				<p style='float:right;text-align:right;'>
					<b>Subtotal:</b><br>
					<b>Shipping:</b><br>
					<br>
					<b>Total:</b>
				</p>
			</div>
		</div>
	</div>
</span>
</template>

<style scoped>
.print-area{
	font-family: 'Roboto', sans-serif;
}
.print-table, .print-table th{
  border: 1px solid black;
  border-collapse: collapse;
  padding-left: 5px;
  padding-right: 5px;
  font-size: 14px;
}
.print-table td {
	height: 21px;
	border-left: 1px solid black;
	border-right: 1px solid black;
  border-collapse: collapse;
  text-align: right;
  padding-left: 5px;
  padding-right: 5px;
}
.print-table td:nth-child(1) {
	text-align: left;
}
.print-area hr {
	border: 1px solid black;
	border-top: 0px;
	margin-top: 1em;
	margin-bottom: 1em;
}
#container {
	width:8.5in;
}
#addresses {
	clear: both;
	width: 100%;
}

@media screen {
  .print-area { display: none; }
}

@media print {
  .print-area { display: block !important; }
}
</style>

<script>
module.exports = {
	props: ['invoice'],

	methods: {
		print () {
			$.print(".print-area")
		}
	}
}
</script>