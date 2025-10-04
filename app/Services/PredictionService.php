<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PredictionService
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.prediction_api.url');
    }

    public function predictSingle(array $data) {
        try {
            $response = Http::timeout(30)
                ->post($this->apiUrl . '/predict-single', $data);

            if ($response->successful()) {
                return $response->json();
            }

            // Tambahkan logging yang lebih informatif
            $statusCode = $response->status();
            $errorBody = $response->body();
            
            Log::error("Prediction API error - Status: {$statusCode}, Response: {$errorBody}");
            
            // Coba decode JSON error jika mungkin
            $errorData = json_decode($errorBody, true);
            $errorMessage = isset($errorData['error']) ? $errorData['error'] : 'Prediction service error';
            
            return [
                'status' => 'error',
                'error_message' => $errorMessage,
                'http_status' => $statusCode,
                'raw_error' => $errorBody // Hati-hati dengan data sensitif
            ];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            // Exception khusus untuk koneksi timeout atau connection refused
            Log::error('Prediction service connection failed: ' . $e->getMessage());
            return [
                'status' => 'error',
                'error_message' => 'Prediction service unavailable - connection failed',
                'details' => 'Service mungkin down atau alamat API salah'
            ];
            
        } catch (\Exception $e) {
            Log::error('Prediction service exception: ' . $e->getMessage());
            return [
                'status' => 'error',
                'error_message' => 'Service unavailable',
                'exception' => $e->getMessage()
            ];
        }
    }

    public function predictBatch(array $data)
    {
        try {
            $response = Http::timeout(30)
                ->post($this->apiUrl . '/predict', $data);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'status' => 'error',
                'error_message' => 'Batch prediction failed'
            ];

        } catch (\Exception $e) {
            Log::error('Batch prediction error: ' . $e->getMessage());
            return [
                'status' => 'error',
                'error_message' => 'Service unavailable'
            ];
        }
    }
}