<?php

namespace Zzyzx4\FreedomPay;


use GuzzleHttp\Client;
use Illuminate\Http\Request;

class Payment
{
    public static function create(Request $request)
    {
        $data = $request->validate([
            'pg_amount' => 'required|integer',
            'client_uin' => 'required|integer',
            'pg_order_id' => 'required',
            'pg_success_url' => 'url',
            'pg_failure_url' => 'url',
            'resource' => 'required',
        ]);

        $client = new Client();
        $url = 'http://127.0.0.1:8000/api/v1/payment/create';

        try {
            $response = $client->post($url, [
                'form_params' => $data,
            ]);
            $response_body = $response->getBody()->getContents();
            return json_decode($response_body, true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Illuminate\Support\Facades\Log::error('Guzzle request error: ' . $e->getMessage());
        }
    }
}
