<?php

namespace Ejetar\AzureADAPIClient\Resources;

use League\OAuth2\Client\Provider\AbstractProvider;
use TheNetworg\OAuth2\Client\Token\AccessToken;

class Base {
    protected string $ref, $version = '1.0';
    protected AccessToken $accessToken;

    public function __construct(protected AbstractProvider $provider) {
        //
    }

    public function ref($suffix = null): string {
        return $this->provider->getRootMicrosoftGraphUri(null)."/v$this->version/$this->resource$suffix";
    }
}
