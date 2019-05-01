<?php

use FedExRestApi\Requests\Authorize;
use FedExRestApi\Requests\RMAv2;

// Authorization action
$auth = new Authorize('7ee99fda-33a1-4429-abaf-a30b95bd1966', 'sM7yM5kK7nJ5nN3jL3nA6kH4qM0wR7eN8wV2kE6bI4oB3bT4bJ', 'DonorDrives', 'sandbox');
$auth->setCredentials('dglushko@donordrives.com', '7gYmHZ8yAWiZt5c');

// Get authorize data for next requests. You can save this data and use it until not expire token
$authResult = $auth->getTokenByCredential();

// Example request data for FedEx RMA v2
$bodyData = [
    "rmaNumber" => "123456789",
    "customer" => [
        "firstName" => "John",
        "lastName" => "Doe",
        "addressLine1" => "Flatbush Ave",
        "addressLine2" => "",
        "city" => "Brooklyn",
        "stateCode" => "NY",
        "zipCode" => "11238",
        "countryCode" => "US",
        "phoneNumber" => "2055555555",
        "emailAddress" => "example@example.com"
    ],
    "orders" => [
        [
            "orderNumber" => "OILPULL8",
            "orderDate" => "2019-01-01",
            "items" => [
                [
                    "sku" => "sku",
                    "quantity" => 1,
                    "returnItemInfo" => [
                        "returnReason" => "Wrong Size"
                    ]
                ]
            ]
        ]
    ]
];

// Creating RMA request using authorize data from previous step
$request = new RMAv2($authResult, 'sandbox');
$rmaResult = $request->createRma($bodyData);

print_r($rmaResult);
