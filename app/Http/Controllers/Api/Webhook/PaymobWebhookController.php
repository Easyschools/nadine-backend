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
        $folder_path = "logs/payment_callback";
        if (!file_exists(storage_path("$folder_path"))) {
            mkdir(storage_path("$folder_path"), 0777, true);
        }
        $filename = 'payment_logs'.date('d-m-y').'.log';
        \File::append(storage_path("$folder_path".DIRECTORY_SEPARATOR.$filename),
            json_encode($request->all())."\n".str_repeat("=", 100)."\n\n");

        return $this->paymobOrderService->processPaymentWebhook($request);
    }

}
