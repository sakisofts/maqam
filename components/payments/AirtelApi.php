<?php

namespace app\components\payments;
use Yii;
use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\CurlTransport;

class AirtelApi extends Component
{
    public $baseUrl;
    public $countryCode;
    public $currencyCode;
    public $clientId;
    public $clientSecret;
    protected $accessToken;
    public $publicKeyPath;
    public $env = 'production'; // Change to 'production' as needed staging


    public function init()
    {
        parent::init();
        $this->accessToken = $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        $response = Yii::$app->airtelAuth->getToken();
        return $response['access_token'];
    }


    protected function generateSignature($payload)
    {
        try {
            $encrypted = AirtelRSAUtil::encrypt($payload, $this->publicKeyPath);
            return $encrypted;
        } catch (\Exception $e) {
            Yii::error('Signature generation failed: ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }

    protected function encryptKeyIv()
    {
        try {
            $aesKey = Yii::$app->security->generateRandomString(32); // 256-bit key
            $iv = Yii::$app->security->generateRandomString(16); // 128-bit IV

            $keyIvPayload = json_encode([
                'key' => base64_encode($aesKey),
                'iv' => base64_encode($iv)
            ]);

            $encrypted = AirtelRSAUtil::encrypt($keyIvPayload, $this->publicKeyPath);
            return $encrypted;
        } catch (\Exception $e) {
            Yii::error('Key-IV encryption failed: ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }


    public function requestPayment($reference, $msisdn, $amount, $description = 'Service Payment')
    {

        $payload = [
            'reference' => $reference,
            'subscriber' => [
                'country' => $this->countryCode ?? 'UG',
                'msisdn' => (int)$msisdn,
            ],
            'transaction' => [
                'amount' => $amount,
                'currency' => $this->currencyCode ?? 'UGX',
                'id' => uniqid('txn'),
                'description' => $description,
            ],
        ];

        $client = new Client([
            'baseUrl' => $this->baseUrl,
            'transport' => [
                'class' => CurlTransport::class,
            ],
            'requestConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . Yii::$app->airtelAuth->getToken()['access_token'],
            'Content-Type' => 'application/json',
            'X-Country' => strtoupper($this->countryCode),
            'X-Currency' => strtoupper($this->currencyCode),
            'x-signature' => $this->generateSignature(json_encode($payload)),
            'x-key' => $this->encryptKeyIv(),
        ];

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('merchant/v2/payments/')
            ->setHeaders($headers)
            ->setContent(json_encode($payload))
            ->setOptions([
                CURLOPT_TIMEOUT => 30,          // request timeout
                CURLOPT_CONNECTTIMEOUT => 30,   // connection timeout
            ])
            ->send();

        if ($response->isOk) {
            return [
                'success' => true,
                'data' => $response->data,
            ];
        }

        // handle API error
        return [
            'success' => false,
            'error_code' => $response->statusCode,
            'error_message' => $response->content,
            'payload_sent' => $payload,
        ];
    }
    public function pay($reference, $msisdn, $amount, $description = 'PAY')
    {

        $payload = [
            'payee' => [
                'currency' => $this->currencyCode ?? 'UGX',
                'msisdn' => (int)$msisdn,
                'name'=>'samuel'
            ],
            'reference' => $reference,
            'pin'=>$this->encryptKeyIv(),
            'transaction' => [
                'amount' => $amount,
                'id' => uniqid('txn'),
                'description' => $description,
                 'type'=>"B2C"
            ],
        ];

        $client = new Client([
            'baseUrl' => $this->baseUrl,
            'transport' => [
                'class' => CurlTransport::class,
            ],
            'requestConfig' => [
                'format' => Client::FORMAT_JSON,
            ],
            'responseConfig' => [
                'format' => Client::FORMAT_JSON
            ],
        ]);

        $headers = [
            'Authorization' => 'Bearer ' . Yii::$app->airtelAuth->getToken()['access_token'],
            'Content-Type' => 'application/json',
            'X-Country' => strtoupper($this->countryCode),
            'X-Currency' => strtoupper($this->currencyCode),
            'x-signature' => $this->generateSignature(json_encode($payload)),
            'x-key' => $this->encryptKeyIv(),
        ];

        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('standard/v2/disbursements/')
            ->setHeaders($headers)
            ->setContent(json_encode($payload))
            ->setOptions([
                CURLOPT_TIMEOUT => 30,          // request timeout
                CURLOPT_CONNECTTIMEOUT => 30,   // connection timeout
            ])
            ->send();

        if ($response->isOk) {
            return [
                'success' => true,
                'data' => $response->data,
            ];
        }

        // handle API error
        return [
            'success' => false,
            'error_code' => $response->statusCode,
            'error_message' => $response->content,
            'payload_sent' => $payload,
        ];
    }


    public function checkPaymentStatus($reference)
    {
        $client = new Client(['baseUrl' => $this->baseUrl]);
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl("standard/v1/payments/$reference")
            ->addHeaders([
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . Yii::$app->airtelAuth->getToken()['access_token'],
                'X-Country' => strtoupper($this->countryCode),
                'X-Currency' => strtoupper($this->currencyCode),
            ])
            ->send();
        return $response->isOk ? $response->data : $response;
    }

    public function handleCallback($rawInput)
    {
        $data = json_decode($rawInput, true);
        Yii::info('Airtel callback received: ' . print_r($data, true), __METHOD__);
        // Example handling
        if (isset($data['transaction']['status']) && $data['transaction']['status'] === 'TS') {
            // Success
            // Update DB, notify user, etc.
        } else {
            // Failed or pending
            // Handle accordingly
        }

        return ['status' => 'success', 'message' => 'Callback handled'];
    }


}
