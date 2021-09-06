<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\OrderInput;
use App\Payment;

class PaymentController extends Controller
{
	
	public function notification(Request $request)
	{
		$payload = $request->getContent();
		$notification = json_decode($payload);


		$validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

		if ($notification->signature_key != $validSignatureKey) {
			return response(['message' => 'Invalid signature'], 403);
		}

		$this->initPaymentGateway();
		$statusCode = null;

		$paymentNotification = new \Midtrans\Notification();
		
		$order = OrderInput::where('code', $paymentNotification->order_id)->firstOrFail();
		if ($order->isPaid()) {
			return response(['message' => 'The order has been paid before'], 422);
		}

		$transaction = $paymentNotification->transaction_status;
		$type = $paymentNotification->payment_type;
		$orderId = $paymentNotification->id_order;
		$fraud = $paymentNotification->fraud_status;

		$vaNumber = null;
		$vendorName = null;
		if (!empty($paymentNotification->va_numbers[0])) {
			$vaNumber = $paymentNotification->va_numbers[0]->va_number;
			$vendorName = $paymentNotification->va_numbers[0]->bank;
		}
		$paymentStatus = null;
		if ($transaction == 'capture') {
			if ($type == 'credit_card') {
				if ($fraud == 'challenge') {
					$paymentStatus = Payment::CHALLENGE;
				} else {
					$paymentStatus = Payment::SUCCESS;
				}
			}
		} else if ($transaction == 'settlement') {
			$paymentStatus = Payment::SETTLEMENT;
		} else if ($transaction == 'pending') {
			$paymentStatus = Payment::PENDING;
		} else if ($transaction == 'deny') {
			$paymentStatus = PAYMENT::DENY;
		} else if ($transaction == 'expire') {
			$paymentStatus = PAYMENT::EXPIRE;
		} else if ($transaction == 'cancel') {
			$paymentStatus = PAYMENT::CANCEL;
		}

		$paymentParams = [
			'id_order' => $order->id,
			'number' => Payment::generateCode(),
			'amount' => $paymentNotification->gross_amount,
			'method' => 'midtrans',
			'status' => $paymentStatus,
			'token' => $paymentNotification->transaction_id,
			'payloads' => $payload,
			'payment_type' => $paymentNotification->payment_type,
			'va_number' => $vaNumber,
			'vendor_name' => $vendorName,
			'biller_code' => $paymentNotification->biller_code,
			'bill_key' => $paymentNotification->bill_key,
		];

		$payment = Payment::create($paymentParams);

		if ($paymentStatus && $payment) {
			\DB::transaction(
				function () use ($order, $payment) {
					if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
						$order->payment = OrderInput::PAID;
						$order->status = OrderInput::CONFIRMED;
						$order->save();
					}
				}
			);
		}

		$message = 'Payment status is : '. $paymentStatus;

		$response = [
			'code' => 200,
			'message' => $message,
		];

		return response($response, 200);
	}

	
	public function completed(Request $request)
	{
		$code = $request->query('id_order');
		$order = Order::where('code', $code)->firstOrFail();
		
		if ($order->payment_status == Order::UNPAID) {
			return redirect('payments/failed?id_order='. $code);
		}

		\Session::flash('success', "Thank you for completing the payment process!");

		return redirect('orders/received/'. $order->id);
	}

	
	public function unfinish(Request $request)
	{
		$code = $request->query('id_order');
		$order = Order::where('code', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}

	public function failed(Request $request)
	{
		$code = $request->query('id_order');
		$order = Order::where('code', $code)->firstOrFail();

		\Session::flash('error', "Sorry, we couldn't process your payment.");

		return redirect('orders/received/'. $order->id);
	}
}
