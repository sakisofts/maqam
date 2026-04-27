<?php

namespace app\components\payments;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\Json;

class AirtelMoneyService extends Component
{
    public $baseUrl;
    public $clientId;
    public $clientSecret;
    public $countryCode;
    public $currencyCode;
    public $pin;
    public $merchantName;

    private $_accessToken;
    private $_tokenExpiry;

    public function init()
    {
        parent::init();
        $configParam = Yii::$app->params['airtelMoney'];
        foreach (['baseUrl', 'clientId', 'clientSecret', 'countryCode', 'currencyCode'] as $property) {
            if (!$this->$property) {
                throw new InvalidConfigException("AirtelMoneyService::{$property} must be set.");
            }
        }
    }

    public function processCollection($msisdn, $amount, $reference, $description)
    {
        $this->validatePhoneAmount($msisdn, $amount);
        $transactionId = $this->generateTransactionId();

        $data = [
            'reference' => $reference,
            'subscriber' => [
                'msisdn' => $msisdn,
                'country' => $this->countryCode
            ],
            'transaction' => [
                'amount' => $amount,
                'currency' => $this->currencyCode,
                'id' => $transactionId,
                'description' => $description
            ]
        ];

        return $this->makeApiRequest('/merchant/v2/payments/', 'POST', $data);
    }

    public function processDisbursement($msisdn, $amount, $reference, $description)
    {
        $this->validatePhoneAmount($msisdn, $amount);

        if (empty($this->pin)) {
            throw new \Exception('PIN is required for disbursement');
        }

        $transactionId = $this->generateTransactionId();

        $data = [
            'reference' => $reference,
            'subscriber' => [
                'msisdn' => $msisdn,
                'country' => $this->countryCode
            ],
            'transaction' => [
                'amount' => $amount,
                'currency' => $this->currencyCode,
                'id' => $transactionId,
                'description' => $description
            ],
            'pin' => $this->pin
        ];

        return $this->makeApiRequest('/standard/v1/disbursements/', 'POST', $data);
    }

    public function checkCollectionStatus($transactionId)
    {
        return $this->checkStatus('/merchant/v2/payments/', $transactionId);
    }

    public function checkDisbursementStatus($transactionId)
    {
        return $this->checkStatus('/standard/v2/disbursements/', $transactionId);
    }

    public function getAccountBalance()
    {
        return $this->makeApiRequest('/standard/v2/accounts/balance');
    }

    public function handleCollectionCallback($data)
    {
        Yii::info('Airtel Money collection callback received: ' . Json::encode($data), __METHOD__);
        return true;
    }

    protected function generateTransactionId()
    {
        return uniqid('AM', true) . mt_rand(1000, 9999);
    }

    protected function validatePhoneAmount($msisdn, $amount)
    {
        if (empty($msisdn)) {
            throw new \Exception('Phone number cannot be empty');
        }
        $amount = (float)$amount;
        if ($amount <= 0) {
            throw new \Exception('Amount must be greater than zero');
        }
    }

    protected function checkStatus($path, $transactionId)
    {
        if (empty($transactionId)) {
            throw new \Exception('Transaction ID cannot be empty');
        }
        return $this->makeApiRequest($path . urlencode($transactionId));
    }

    public function getAccessToken()
    {
        $response = Yii::$app->airtelAuth->getToken();
        return $response['access_token'];
    }

    protected function makeApiRequest($endpoint, $method = 'GET', $data = [])
    {
        $token = $this->getAccessToken();
        $url = rtrim($this->baseUrl, '/') . $endpoint;

        $headers = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'X-Country: ' . $this->countryCode,
            'X-Currency: ' . $this->currencyCode,
            'Accept: application/json'
        ];

        $postFields = !empty($data) ? Json::encode($data) : null;
        return $this->makeCurlRequest($url, $method, $headers, $postFields);
    }

    protected function makeCurlRequest(string $url, string $method = 'GET', array $headers = [], $postFields = null, bool $verifySSL = true, int $timeout = 30): array
    {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => $verifySSL,
            CURLOPT_TIMEOUT => $timeout,
        ]);

        if (!empty($postFields)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($postFields) ? http_build_query($postFields) : $postFields);
        }

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if ($response === false) {
            throw new \Exception("cURL error: $error");
        }

        $isJson = strpos($contentType, 'application/json') !== false;
        $decodedResponse = $isJson ? json_decode($response, true) : null;

        if ($httpCode < 200 || $httpCode >= 300) {
            $message = $decodedResponse['message']
                ?? $decodedResponse['error_description']
                ?? $decodedResponse['error']
                ?? "Unexpected HTTP status code: $httpCode";
            throw new \Exception("API request failed: $message");
        }

        return $decodedResponse ?? ['rawResponse' => $response];
    }

    protected function isJson($string)
    {
        if (!is_string($string)) return false;
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
