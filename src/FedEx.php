<?php

namespace FedExRestApi;

class FedEx
{
    private $sandbox = false;
    private $restURL;
    private $timeout = 30;
    private $reqData = [];
    private $reqHeaders = [];
    private $headers = [];
    private $method = 'POST';

    private $clientId;
    private $clientSecret;

    public function __construct($mode = 'live', $clientId = null, $clientSecret = null)
    {
        if ($mode == 'sandbox')
            $this->sandbox = true;

        $this->restURL = $this->sandbox ? 'https://api-sandbox.supplychain.fedex.com/api/sandbox' : 'https://api.supplychain.fedex.com/api';

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function setRequestData($data)
    {
        $this->reqData = array_merge($this->reqData, $data);
    }

    public function setRequestHeaders($headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        $collectedHeaders = $this->collectHeaders($headers);
        $this->reqHeaders = array_merge($this->reqHeaders, $collectedHeaders);
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setGrantType($grantType)
    {
        $this->grant_type = $grantType;
    }

    public function setScope($scope)
    {
        $this->grant_type = $scope;
    }

    public function setTimeout($milliseconds)
    {
        $this->timeout = $milliseconds;
    }

    public function jsonToArray($data)
    {
        return json_decode($data, true);
    }

    public function arrayToJson($data)
    {
        return json_encode($data);
    }

    public function collectHeaders($array)
    {
        $cHeaders = [];
        foreach ($array as $key => $value) {
            $cHeaders[] = $key . ': ' . $value;
        }
        return $cHeaders;
    }

    public function buildQuery($array)
    {
        return http_build_query($array, '', '&');
    }

    public function doRequest($path)
    {
        $curl = curl_init();
        $body = '';

        if ($this->headers['content-type'] == 'application/x-www-form-urlencoded') {
            $body = $this->buildQuery($this->reqData);
        }
        if ($this->headers['content-type'] == 'application/json') {
            $body = $this->arrayToJson($this->reqData);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->restURL . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $this->method,
            CURLOPT_HTTPHEADER => $this->reqHeaders,
            CURLOPT_POSTFIELDS => $body
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            throw new \Exception("cURL Error #: " . $err, 1);
        } else {
            return $response;
        }
    }
}
