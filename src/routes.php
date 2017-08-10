<?php
$routes = [
    'metadata',
    'test',
    'getInstitutions', //test /metadata 1
    'getAccessToken', //test /metadata 1
    'getAuth', //test /metadata 1
    'getItem', //test /metadata 1
    'updateAccessTokenVersion', //not test /metadata 1
    'deleteItem',   // test 1
    'getIdentity',   //need test with normal client /metadata 1
    'updateItemWebhook', //test / metadata 1
    'rotateAccessToken', // test metadata 1
    'getAccountsBalance', //test metadata 1
    'getIncome', // need test with normal client 1
    'getInstitutionById', //test metadata 1
    'getCategories', //test metadata 1
    'searchInstitution', //test metadata 0
    'webhookEvent',
    'getAccounts', // metadata 1
    'getPublicToken', //metadata 1
    'getAccountsTransactions', //metadata 1
    'resetItemLogin'

];
foreach($routes as $file) {
    require __DIR__ . '/../src/routes/'.$file.'.php';
}
