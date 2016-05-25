<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Mail;
use App\Invoice;

class EmailController extends Controller
{
	public function invoice($id)
	{
		$invoice = Invoice::findOrFail($id);

		Mail::queue('emails.invoice', ['invoice' => $invoice], function($message) use ($invoice) {
			// TODO: Add email setting
			$message->from('info@pangolin4x4.com');
			$message->to($invoice->email);
			$message->subject("Pangolin4x4: INV".$invoice->id);
		});
	}
}
