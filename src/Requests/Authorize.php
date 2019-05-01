<?php

namespace FedExRestApi\Requests;

use FedExRestApi\FedEx;

class Authorize extends FedEx
{
    private $username;
    private $password;
    private $grantType = 'password';
    private $scope = 'Fulfillment_Returns';
    private $path = '/fsc/oauth2/token';
    private $orgName = 'orgName';

    public function __construct(
        $clientId,
        $clientSecret,
        $orgName = 'orgName',
        $mode = 'live'
    ) {
        $this->orgName = $orgName;

        $this->setRequestData([
            "client_id"         => $clientId,
            "client_secret"     => $clientSecret,
            "grant_type"        => $this->grantType,
            "scope"             => $this->scope,
        ]);
        $this->setRequestHeaders([
            "accept"            => "application/json",
            "content-type"      => "application/x-www-form-urlencoded",
            "x-org-name"        => $this->orgName,
            "org_name"          => $this->orgName
        ]);

        parent::__construct($mode, $clientId, $clientSecret);
    }

    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getTokenByCredential()
    {
        $this->setRequestData([
            "username"          => $this->username,
            "password"          => $this->password
        ]);

        $res = $this->doRequest($this->path);

        return $this->jsonToArray($res);
    }
}
