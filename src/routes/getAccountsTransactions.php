<?php

$app->post('/api/Plaid/getAccountsTransactions', function ($request, $response) {

    $requestUrl = '/transactions/get';
    $option = array(
        "clientId" => "client_id",
        "secret" => "secret",
        "accessToken" => "access_token",
        "startDate" => "start_date",
        "endDate" => "end_date",
        "count" => "count", //elem for option arr
        "offset" => "offset" //elem for option arr
    );

    $arrayType = array();
    $queryParam =array();
    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, ["clientId","secret","accessToken","startDate","endDate"]);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }



    //Change alias and formatted array
    foreach($option as $alias => $value)
    {

        if(!empty($postData['args'][$alias]))
        {

            if(isset($arrayType[$alias]))
            {
                $postData['args'][$alias] = implode($arrayType[$alias],$postData['args'][$alias]);
            }

            $queryParam[$value] = $postData['args'][$alias];
        }
    }


    //organize time format
    $queryParam['start_date'] = date('Y-m-d',strtotime($queryParam['start_date']));
    $queryParam['end_date'] = date('Y-m-d',strtotime($queryParam['end_date']));

    $client = $this->httpClient;
    $url = $settings['baseUrl'].$requestUrl;
    if(!empty($queryParam['count']))
    {
        $arr = $queryParam['count'];
        unset($queryParam['count']);
        $queryParam['options']['count'] = $arr;
    }

    if(!empty($queryParam['offset']))
    {
        $arr = $queryParam['offset'];
        unset($queryParam['offset']);
        $queryParam['options']['offset'] = $arr;
    }

    try {

        $resp =  $client->request('POST', $url ,['json' => $queryParam] );



        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {

            $dataBody = $resp->getBody()->getContents();

            $result['callback'] = 'success';
            $result['contextWrites']['to'] = array('result' => json_decode($dataBody) );

        } else {
            $result['callback'] = 'error';
            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
            $result['contextWrites']['to']['status_msg'] = $resp->getBody()->getContents();
        }
    } catch (\GuzzleHttp\Exception\ClientException $exception) {
        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;
    } catch (GuzzleHttp\Exception\ServerException $exception) {
        $responseBody = $exception->getResponse()->getBody()->getContents();
        if(empty(json_decode($responseBody))) {
            $out = $responseBody;
        } else {
            $out = json_decode($responseBody);
        }
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'API_ERROR';
        $result['contextWrites']['to']['status_msg'] = $out;
    } catch (GuzzleHttp\Exception\ConnectException $exception) {
        $responseBody = $exception->getResponse()->getBody(true);
        $result['callback'] = 'error';
        $result['contextWrites']['to']['status_code'] = 'INTERNAL_PACKAGE_ERROR';
        $result['contextWrites']['to']['status_msg'] = 'Something went wrong inside the package.';
    }
    return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($result);


});
