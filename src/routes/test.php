<?php

$app->post('/api/Plaid/test', function ($request, $response) {


    $option = array(
        "apiKey" => "apiKey",
        "newsSource" => "source",
        "typeOfList" => "sortBy"
    );
    $arrayType = array();

    $queryParam =array();
    $settings = $this->settings;
    $checkRequest = $this->validation;
    $validateRes = $checkRequest->validate($request, []);
    if(!empty($validateRes) && isset($validateRes['callback']) && $validateRes['callback']=='error') {
        return $response->withHeader('Content-type', 'application/json')->withStatus(200)->withJson($validateRes);
    } else {
        $postData = $validateRes;
    }


   // $url = "https://newsapi.org/v1/articles";

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




    $client = $this->httpClient;







    try {
        $request = $client->post('https://sandbox.plaid.com/link/item/create', [
            'json' => [
                'public_key' => $settings['publicKey'],
                'credentials' => ['username' => 'user_good','password' => 'pass_good'],
                'initial_products' => ['transactions','identity'],
                'institution_id' => 'ins_23'
            ]
        ]);

        $dataBody = $request->getBody()->getContents();
        print_r($dataBody);
        exit();
        $result['callback'] = 'success';
        $result['contextWrites']['to'] = array('result' => $dataBody );

  //      $resp =  $client->request('GET', $url ,['query' => $queryParam,'headers' => ['X-Api-Key' => $apiKey]] );
//
//
//
//        if(in_array($resp->getStatusCode(), ['200', '201', '202', '203', '204'])) {
//
//            $dataBody = $resp->getBody()->getContents();
//
//                $result['callback'] = 'success';
//                $result['contextWrites']['to'] = array('result' =>$dataBody );
//



//        } else {
//            $result['callback'] = 'error';
//            $result['contextWrites']['to']['status_code'] = 'API_ERROR';
//            $result['contextWrites']['to']['status_msg'] = $resp->getBody()->getContents();
//        }
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
