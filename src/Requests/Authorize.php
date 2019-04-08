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
    private $data = [];

    public function __construct(
        $clientId,
        $clientSecret,
        $orgName = 'orgName',
        $mode = 'live'
    ) {
        parent::__construct($clientId, $clientSecret, $mode);
    }

    public function setGrantType($grantType)
    {
        $this->grant_type = $grantType;
    }

    public function setScope($scope)
    {
        $this->grant_type = $scope;
    }

    public function setData($data)
    {
        $this->data = $data;
    }
    public function setCredentials($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function getTokenByPassword($username, $password)
    {
        $this->setCredentials($username, $password);

        $res = parent::doRequest(
            $this->path,
            'POST',
            [
                "x-org-name: " . $this->orgName,
                "org_name: " . $this->orgName,
                "content-type: application/x-www-form-urlencoded"
            ],
            http_build_query($this->data, '', '&')
        );

        return $res;
    }
}
