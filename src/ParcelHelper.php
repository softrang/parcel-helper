<?php

namespace Softrang\ParcelHelper;

use GuzzleHttp\Client;

class ParcelHelper
{
    protected $client;
    protected $packzyUrl;
    protected $packzyApiKey;
    protected $packzySecretKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->packzyUrl = config('parcel-helper.packzy_url', env('PACKZY_BASE_URL'));
        $this->packzyApiKey = config('parcel-helper.api_key', env('PACKZY_API_KEY'));
        $this->packzySecretKey = config('parcel-helper.secret_key', env('PACKZY_SECRET_KEY'));
    }

    /**
     * ✅ Place an order via Packzy API
     */
    public function createOrder(array $data)
    {
        $response = $this->client->post($this->packzyUrl . '/create_order', [
            'headers' => [
                'Api-key' => $this->packzyApiKey,
                'secret-key' => $this->packzySecretKey,
                'Accept' => 'application/json'
            ],
            'json' => $data
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * 🔍 Get report from Steadfast API
     */
    public function getReportByPhone($phone)
    {
        $url = "https://steadfast.com.bd/user/consignment/getbyphone/{$phone}";

        $response = $this->client->get($url, [
            'auth' => [
                'softrang24@gmail.com',
                'Soft454546'
            ],
            'headers' => [
                'Accept' => 'application/json'
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
