<?php

// Odoo server information
$url = 'http://your-odoo-domain.com/jsonrpc';
$db = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

// 1. Authenticate to get UID
$loginPayload = [
    'jsonrpc' => '2.0',
    'method'  => 'call',
    'params'  => [
        'service' => 'common',
        'method'  => 'login',
        'args'    => [$db, $username, $password]
    ],
    'id' => time()
];

$response = sendRequest($url, $loginPayload);
$uid = $response['result'];

echo "Authenticated UID: $uid\n";

// 2. Call search_read on `res.partner`
$dataPayload = [
    'jsonrpc' => '2.0',
    'method'  => 'call',
    'params'  => [
        'service' => 'object',
        'method'  => 'execute_kw',
        'args'    => [
            $db,
            $uid,
            $password,
            'res.partner',       // model
            'search_read',       // method
            [[['is_company', '=', true]]],  // domain filter
            ['fields' => ['id', 'name', 'email']]
        ]
    ],
    'id' => time()
];

$dataResponse = sendRequest($url, $dataPayload);

// Output raw response
header('Content-Type: application/json');
echo json_encode($dataResponse, JSON_PRETTY_PRINT);


// Function to send request to Odoo
function sendRequest($url, $payload)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        die("cURL error: " . curl_error($ch));
    }

    curl_close($ch);

    return json_decode($response, true);
}
