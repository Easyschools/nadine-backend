<?php

namespace App\Services\Api\Payment;

use App\Interfaces\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymobPaymentService extends BasePaymentService implements PaymentGatewayInterface

{
    protected  $api_key;
    protected  $secret_key;
    protected  $public_key;

    protected  $header;

    public function __construct()
    {
        $this->base_url   = config("paymob.base_url");
        $this->api_key    = config("paymob.api_key");
        $this->secret_key = config("paymob.secret_key");
        $this->public_key = config("paymob.public_key");
        $this->header     = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function generateToken(): ?string
    {
        try {
            $response = $this->buildRequest('POST', '/api/auth/tokens', ['api_key' => $this->api_key]);

            if ($response->getData(true)['success']) {
                return $response->getData(true)['data']['token'];
            }

            Log::error('Token generation failed', ['response' => $response->getData(true)]);
            return null;
        } catch (\Exception $e) {
            Log::error('Token generation error', ['message' => $e->getMessage()]);
            return null;
        }
    }

    public function sendPayment(Request $request): array
    {
        try {
            $authToken = $this->generateToken();
            if (!$authToken) {
                throw new \Exception('Failed to generate authentication token');
            }
            $this->header['Authorization'] = 'Token ' . $this->secret_key;
            $extras = $request->input('special_reference', []);

            if (empty($extras) && $request->has('special_reference')) {
                $extras['special_reference'] = $request->input('special_reference');
            }

            $data     = [
                'amount'            => $request->input('amount'),
                'currency'          => $request->input('currency', 'EGP'),
                'payment_methods'   => $request->input('payment_methods'),
                'items'             => $request->input('items'),
                'billing_data'      => $request->input('billing_data'),
                'customer'          => $request->input('customer'),
                'special_reference' =>  rand(111,999).$extras,
            ];
            $response = $this->buildRequest('POST', '/v1/intention/', $data);
            if ($response->getData(true)['success']) {
                $responseData = $response->getData(true)['data'];
                return [
                    'success'       => true,
                    'client_secret' => $responseData['client_secret'],
                    'payment_key'   => $responseData['payment_keys'][0],
                    'url'           => "https://accept.paymob.com/unifiedcheckout/?publicKey={$this->public_key}&clientSecret={$responseData['client_secret']}",
                ];
            }

            Log::error('Payment initiation failed', ['response' => $response->getData(true)]);
            return ['success' => false, 'message' => 'Payment initiation failed'];
        } catch (\Exception $e) {
            Log::error('Payment processing error', ['message' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }


    public function callBack(Request $request): array
    {

        try {

            $response = $request->all();
            Log::info('Paymob Callback Received', ['response' => $response]);
            $success           = false;
            $transactionStatus = $response['txn_response_code'] ?? null;
            $successStatuses   = $response['success'];

            if ($transactionStatus && $successStatuses) {
                $success = true;
            }

            return [
                'success'            => $success,
                'order_id'           => $response['merchant_order_id'] ?? null,
                'transaction_id'     => $response['id'] ?? null,
                'transaction_status' => $transactionStatus,
                'response'           => $response
            ];
        } catch (\Exception $e) {
            Log::error('Callback processing error', ['message' => $e->getMessage()]);
            return [
                'success'  => false,
                'message'  => $e->getMessage(),
                'response' => $request->all()
            ];
        }
    }

}