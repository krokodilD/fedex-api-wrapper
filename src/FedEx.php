<?php

namespace FedExRestApi;

class FedEx
{
    private $sandbox = false;
    private $restURL;

    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret, $mode = 'live')
    {
        if ($mode == 'sandbox')
            $this->sandbox = true;

        $this->restURL = $this->sandbox ? 'https://api-sandbox.supplychain.fedex.com/api/sandbox' : 'https://api.supplychain.fedex.com/api/fsc';

        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function doRequest($path, $type, $headers)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->restURL . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
