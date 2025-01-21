<?php

namespace App\Services\Api\Payment;

use App\Models\Order\Order;
use App\Services\Api\Order\OrderApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymobOrderService
{
    private $paymobPaymentService;
    private $orderApiService;

    public function __construct(PaymobPaymentService $paymobPaymentService, OrderApiService $orderApiService)
    {
        $this->paymobPaymentService = $paymobPaymentService;
        $this->orderApiService      = $orderApiService;

    }

    public function preparePaymentData(Order $order)
    {
        $user = $order->user;


        if ($order->payment_type_id == 2) {
            $integration_id = 1657492;
        } elseif ($order->payment_type_id == 3) {
            $integration_id = 1773286;
        }

        return [
            "amount"            => $order->grand_total * 100,
            "currency"          => "EGP",
            "payment_methods"   => [$integration_id],
            "items"             => [],
            "billing_data"      => [
                "first_name"   => $user->name,
                "last_name"    => 'test',
                "phone_number" => $user->phone,
                "email"        => $user->email,
            ],
            "customer"          => [
                "first_name" => $user->name,
                "last_name"  => 'test',
                "email"      => $user->email
            ],
            'special_reference' => $order->id,
        ];
    }


    public function processPayment(Order $order)
    {
        $paymentData = $this->preparePaymentData($order);
        $response = $this->paymobPaymentService->sendPayment(new Request($paymentData));
        if ($response['success']) {
            $order->update([
                'payment_status'         => 'processing',
                'payment_integration_id' => $response['payment_key']['integration'],
                'payment_response'       => $response
            ]);
            return $response['url'];
        }

        throw new \Exception('Payment processing failed');
    }



    public function processPaymentWebhook(Request $request)
    {
        Log::channel('paymob')->info('Full Webhook Payload', [
            'complete_payload' => $request->all(),
            'headers' => $request->headers->all(),
        ]);
        try {
            return $this->handlePaymentTransaction($request->all());
        } catch (\Exception $e) {
            Log::channel('paymob')->error('Webhook Processing Error', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString()
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

     private function handlePaymentTransaction($payload)
    {
        $transaction = $payload['obj'] ?? [];
        $orderData = $transaction['order'] ?? [];
        $orderId       = $orderData['merchant_order_id'] ?? null;
        $transactionId = $orderData['id'] ?? null;
        $amount        = ($orderData['amount_cents'] ?? 0) / 100;
//        $isSuccess     = filter_var($transaction['success'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $status        = $this->determinePaymentStatus($payload);
        if (!$orderId || !$transactionId) {
            Log::warning('Incomplete payment transfer data', [
                'payload' => $payload
            ]);
            return response()->json(['status' => 'incomplete'], 200);
        }

        if ($orderId !== null) {
            $orderId = substr($orderId, 3);
        }

        $order = Order::find($orderId);
        if (!$order) {
            Log::warning('Order not found for payment webhook', [
                'order_id' => $orderId
            ]);
            return response()->json(['status' => 'order_not_found'], 200);
        }

        try {
            $order->update([
                'payment_status'   => $status,
                'transaction_id'   => $transactionId,
                'amount_paid'      => $amount,
                'payment_response' => $payload
            ]);
            return response()->json(['status' => 'Completed'], 200);
        } catch (\Exception $e) {
            Log::error('Error updating order after payment webhook', [
                'message'  => $e->getMessage(),
                'order_id' => $orderId
            ]);

            return response()->json(['status' => 'processing_error'], 400);
        }
    }


     private function determinePaymentStatus($payload)
    {
        if (filter_var($payload['obj']['success'], FILTER_VALIDATE_BOOLEAN)) {
            return 'completed';
        }

        if (filter_var($payload['is_refunded'], FILTER_VALIDATE_BOOLEAN)) {
            return 'refunded';
        }

        if (filter_var($payload['is_voided'], FILTER_VALIDATE_BOOLEAN)) {
            return 'voided';
        }

        return 'failed';
    }

}