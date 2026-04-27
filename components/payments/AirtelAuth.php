<?php

namespace app\components\payments;

use yii\base\Component;
use yii\httpclient\Client;

class AirtelAuth extends Component
{
    public $clientId;
    public $clientSecret;
    public $env = 'staging'; // Change to 'production' as needed staging

    private $baseUrls = [
//        'staging' => 'https://openapiuat.airtel.africa/',
        'staging' => 'https://openapi.airtel.africa/',
        'production' => 'https://openapi.airtel.africa/',
    ];

    public function getToken()
    {
        $client = new Client(['baseUrl' => $this->baseUrls[$this->env]]);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl('auth/oauth2/token')
            ->addHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->setContent(json_encode([
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type' => 'client_credentials',
            ]))
            ->send();

        if ($response->isOk) {
            return $response->data;
        } else {
            throw new \Exception('Failed to get access token: ' . $response->content);
        }
    }
}
