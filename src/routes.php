<?php
$routes = [
    'metadata',
   // 'test',
    'getAllInstitutions',
    'getAccessToken',
    'getAuth',
    'getSingleItem',
    'deleteItem',
    'getIdentity',
    'createWebhook',
    'updateWebhook',
    'rotateAccessToken',
    'getAccountsBalance',
    'getIncome',
    'getSingleInstitution',
    'getCategories',
    'searchInstitution',
    'webhookEvent',
    'getAccounts',
    'getPublicToken',
    'getAccountsTransactions',
    'resetItemLogin'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
