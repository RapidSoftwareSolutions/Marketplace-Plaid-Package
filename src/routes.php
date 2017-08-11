<?php
$routes = [
    'metadata',
    'test',
    'getInstitutions',
    'getAccessToken',
    'getAuth',
    'getItem',
    'updateAccessTokenVersion',
    'deleteItem',
    'getIdentity',
    'updateItemWebhook',
    'rotateAccessToken',
    'getAccountsBalance',
    'getIncome',
    'getInstitutionById',
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
