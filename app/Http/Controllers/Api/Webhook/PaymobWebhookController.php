<?php

namespace App\Http\Controllers\Api\Webhook;

use App\Http\Controllers\Controller;
use App\Services\Api\Payment\PaymobOrderService;
use Illuminate\Http\Request;

class PaymobWebhookController extends Controller
{
    private $paymobOrderService;

    public function __construct(PaymobOrderService $paymobOrderService)
    {
        $this->paymobOrderService = $paymobOrderService;
    }

    public function processPaymentWebhook(Request $request)
    {
        return $this->paymobOrderService->processPaymentWebhook($request);
    }

}
