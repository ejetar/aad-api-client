<?php

namespace Ejetar\AzureADAPIClient\Resources;

use TheNetworg\OAuth2\Client\Provider\Azure;
use TheNetworg\OAuth2\Client\Token\AccessToken;

class Base {
    protected string $ref, $version = '1.0';
    protected AccessToken $accessToken;

    public function __construct(protected Azure $provider) {
        //
    }

    public function ref($suffix = null): string {
        return $this->provider->getRootMicrosoftGraphUri(null)."/v$this->version/$this->resource$suffix";
    }
}
