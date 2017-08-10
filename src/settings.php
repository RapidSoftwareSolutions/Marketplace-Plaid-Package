<?php
return [
    'settings' => [
        'baseUrl' => 'https://sandbox.plaid.com',
        'clientId' => '59845ffcbdc6a4059887f2d2',
        'publicKey' => '4e4efc9538a3810003c54cb62bffa2',
        'secret' => '0a3cc73a6836ab5db07247b04638a7',
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ]
    ]
];
