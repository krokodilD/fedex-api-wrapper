<?php

use FedExRestApi\Requests\Authorize;

$auth = new Authorize('7ee99fda-33a1-4429-abaf-a30b95bd1966', 'sM7yM5kK7nJ5nN3jL3nA6kH4qM0wR7eN8wV2kE6bI4oB3bT4bJ', 'DonorDrives');

$res = $auth->getTokenByPassword('dglushko@donordrives.com', '7gYmHZ8yAWiZt5c');

var_dump($res);
