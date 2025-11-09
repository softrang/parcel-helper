<?php
namespace Softrang\ParcelHelper;


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
public function createOrder(array $payload): array
{
$required = ['invoice','recipient_name','recipient_phone','recipient_address','cod_amount'];
foreach ($required as $field) {
if (empty($payload[$field])) {
throw new \InvalidArgumentException("Missing required field: $field");
}
}


try {
$response = $this->http->post('/create_order', [
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
