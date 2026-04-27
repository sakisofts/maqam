<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'bsVersion' => '5.x',
    'airtelMoney' => [
        'class' => 'app\components\payments\AirtelMoneyService',
        'baseUrl' => 'https://openapiuat.airtel.ug',
//        'baseUrl' => 'https://openapi.airtel.africa/',
        'clientId' => '987c2bd9-a8a5-4027-9188-e7d4aa5dcd2e',
        'clientSecret' => '8ad6dba0-1ca2-49aa-8fcc-0e24a0238dad',
        'countryCode' => 'UG',
        'currencyCode' => 'Ugx',
        'pin' => '',
        'merchantName' => 'BW0GG0QZ',
    ],
    'clientId'=>'987c2bd9-a8a5-4027-9188-e7d4aa5dcd2e',
    'secret'=>'8ad6dba0-1ca2-49aa-8fcc-0e24a0238dad'
];
