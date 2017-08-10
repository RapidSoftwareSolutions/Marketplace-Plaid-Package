<?php
$routes = [
    'metadata',
    'test',
    'getInstitutions', //test /metadata
    'getAccessToken', //test /metadata
    'getAuth', //test /metadata
    'getItem', //test /metadata
    'updateAccessTokenVersion', //not test /metadata
    'deleteItem',   //not test
    'getIdentity',   //need test with normal client /metadata
    'updateItemWebhook', //test / metadata
    'rotateAccessToken', //not test metadata
    'getAccountsBalance', //test metadata
    'getIncome', // need test with normal client
    'getInstitutionById', //test metadata
    'getCategories', //test metadata
    'searchInstitution', //test metadata
    'webhookEvent',
    'getAccounts', // metadata
    'getPublicToken', //metadata
    'getAccountsTransactions' //metadata


];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
