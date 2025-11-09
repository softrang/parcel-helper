<?php

namespace Softrang\ParcelHelper;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class ParcelHelper
{
    private string $baseUrl;
    private string $apiKey;
    private string $secretKey;
    private Client $http;

    public function __construct(array $config = [])
    {
        $this->baseUrl = $config['base_url'] ?? 'https://portal.packzy.com';
        $this->apiKey = $config['api_key'] ?? getenv('PACKZY_API_KEY') ?: ($config['PACKZY_API_KEY'] ?? '');
        $this->secretKey = $config['secret_key'] ?? getenv('PACKZY_SECRET_KEY') ?: ($config['PACKZY_SECRET_KEY'] ?? '');

        $this->http = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 10,
        ]);
    }

    /**
     * Create an order/consignment
     *
     * Required input keys:
     * - invoice (string)
     * - recipient_name (string)
     * - recipient_phone (string)
     * - recipient_address (string)
     * - cod_amount (numeric)
     *
     * @param array $payload
     * @return array
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function steadfastCreateOrder(array $payload): array
    {
        $required = ['invoice', 'recipient_name', 'recipient_phone', 'recipient_address', 'cod_amount'];
        foreach ($required as $field) {
            if (empty($payload[$field])) {
                throw new \InvalidArgumentException("Missing required field: $field");
            }
        }

        try {
            $response = $this->http->post('/api/v1/create_order', [
                'headers' => [
                    'Api-Key' => $this->apiKey,
                    'Secret-Key' => $this->secretKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $body = (string) $response->getBody();
            $decoded = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \RuntimeException('Invalid JSON response from API');
            }

            return $decoded;
        } catch (GuzzleException $e) {
            throw new \RuntimeException('HTTP request failed: ' . $e->getMessage());
        }
    }
}
