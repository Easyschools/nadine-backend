<?php

namespace App\Services\Api\Payment;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class BasePaymentService
{
    /**
     * Create a new class instance.
     */
    protected  $base_url;
    protected  $header;
    protected function buildRequest($method, $url, $data = null,$type='json'): JsonResponse
    {
        try {

            $response = Http::withHeaders($this->header)->send($method, $this->base_url . $url, [
                $type => $data
            ]);
            return response()->json([
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
            ], $response->status());
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}