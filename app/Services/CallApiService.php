<?php

namespace App\Services;
use Illuminate\Http\Request;

class CallApiService
{
    public function callApi($method, $uri, $data = [])
    {
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . session('api_token'),
            'HTTP_ACCEPT' => 'application/json'
        ];

        $apiRequest = Request::create($uri, $method, $data, [], [], $headers);
        $response = app()->handle($apiRequest);

        $status = $response->getStatusCode();
        $content = json_decode($response->getContent(), true);

        if ($status !== 200 && $status !== 201) {
            $message = $content['message'] ?? 'Something went wrong.';
            return ['error' => $message];
        }

        return ['data' => $content['data'] ?? $content];
    }

}
