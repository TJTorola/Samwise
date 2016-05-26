<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Thank You For Your Order!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; color: black;">
 <table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr style="background-color: #ce4229; height: 5px;">
		<td></td>
	</tr>
		<tr style="background-color: #404040; color: white;">
		<td style="padding:5px 5px 5px 5px; text-align: right;">
		 Thank You For Your Order!
		</td>
		</tr>
		<tr>
		<td style="padding:5px 5px 5px 5px;">
		Dear, {{ $invoice->first_name }} {{ $invoice->last_name }}<br>
		We have recieved your order at Pangolin 4x4, the full invoice is as follows.
		</td>
		</tr>
		<tr>
		<td style="text-align: left; padding:5px 5px 5px 5px;">
			@if ($invoice->seperate_billing)
			<b>Ship To:</b><br>
			@else
			<b>Bill/Ship To:</b><br>
			@endif
			{{ $invoice->first_name }} {{ $invoice->last_name }}
			@if ($invoice->company != "")
			of {{ $invoice->company }}
			@endif
			<br>
			{{ $invoice->street_address_first }}<br>
			@if ($invoice->street_address_second != "")
			{{ $invoice->street_second }}<br>
			@endif
			@if ($invoice->apt)
			(Apt/Suite/Bld): {{ $invoice->apt }}
			@endif
			{{ $invoice->city }}, {{ $invoice->state }} {{ $invoice->zip }}<br>
			{{ $invoice->country }}<br>

			@if ($invoice->seperate_billing)
			<br>
			<b>Bill To:</b><br>
			{{ $invoice->billing_first_name }} {{ $invoice->billing_last_name }}
			@if ($invoice->billing_company != "")
			of {{ $invoice->billing_company }}
			@endif
			<br>
			{{ $invoice->billing_street_address_first }}<br>
			@if ($invoice->billing_street_address_second != "")
			{{ $invoice->billing_street_address_second }}<br>
			@endif
			@if ($invoice->billing_apt)
			(Apt/Suite/Bld): {{ $invoice->billing_apt }}<br>
			@endif
			{{ $invoice->billing_city }}, {{ $invoice->billing_state }} {{ $invoice->billing_zip }}<br>
			{{ $invoice->billing_country }}<br>
			@endif

			@if ($invoice->notes != "")
			<br><b>Notes:</b><br>
			{{ $invoice->notes }}
			@endif
		</td>
		</tr>

		<tr>
		<td style="padding:5px 5px 5px 5px;">
		<b>Cart:</b>
		<!-- START INVOICE TABLE -->
		<table border="1" cellpadding="1" cellspacing="0" width="100%" style="border-style: solid;">
			<tr>
				<td style="border-style: solid;">Item Description</td>
				<td style="border-style: solid;">Quantity</td>
				<td style="border-style: solid;">Unit Cost</td>
				<td style="border-style: solid;">Cost</td>
			</tr>
			@foreach ($invoice->items as $item)
			<tr style="font-size: 13px;">
				<td style="border-style: solid;">{!! nl2br($item->name) !!}</td>
				<td style="border-style: solid;">{{ $item->count }}</td>
				<td style="border-style: solid;">{{ returnUSD($item->price / 100) }}</td>
				<td style="border-style: solid;">{{ returnUSD(($item->price * $item->count) / 100) }}</td>
			</tr>
			@endforeach
		</table>
		<!-- END INVOICE -->
		</td>
	</tr>
	<tr>
		<td style="padding:5px 5px 5px 5px; text-align: right;">
			<b>Subtotal: </b>{{ returnUSD($invoice->subtotal / 100) }}<br>
			@if ($invoice->shipping_cost == null)
			<hr>
			<i>We will calculate your shipping as soon as possible and bill you for the total amount.</i>
			@else
			<b>Shipping: </b>{{ returnUSD($invoice->shipping_cost / 100) }}
			<hr>
			<b>Total: </b>{{ returnUSD(($invoice->shipping_cost + $invoice->sub_total) / 100) }}
			@endif
		</td>
	</tr>
	<tr>
		<td style="padding:5px 5px 5px 5px;">
			You are welcome to respond to this email with any questions or concerns you have about this order and we will get back to you as soon as we can.<br>
			<br>
			Happy Roving,<br>
			- Pangolin 4x4
		</td>
	</tr>
 </table>
</body>
</html>