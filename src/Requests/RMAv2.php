<?php

namespace FedExRestApi\Requests;

use FedExRestApi\FedEx;

class RMAv2 extends FedEx
{
    private $path = '/v2/rmas';

    public function __construct(
        $authData,
        $timeout = null,
        $mode = 'live'
    ) {
        if ($authData['token_type'] == 'bearer') {
            $tokenType = "Bearer";
        } else {
            throw new \Exception("Unknown authorization token type", 1);
        }
        $this->setRequestHeaders([
            "accept"            => "application/json",
            "content-type"      => "application/json",
            "authorization"     => "{$tokenType} {$authData['access_token']}"
        ]);

        if (is_int($timeout)) $this->setTimeout($timeout);

        parent::__construct($mode);
    }

    public function createRma($body)
    {
        if (is_string($body)) {
            $body = $this->jsonToArray($body);
        }

        if (!is_array($body) or empty($body)) {
            throw new \Exception("The body for RMA request is empty or incorrect", 1);
        }

        $this->setRequestData($body);

        $res = $this->doRequest($this->path);

        return $this->jsonToArray($res);
    }
}
