<?php

namespace Ejetar\AzureADAPIClient;

use Ejetar\AzureADAPIClient\Resources\Aplications;
use Ejetar\AzureADAPIClient\Resources\ServicePrincipals;
use Ejetar\AzureADAPIClient\Resources\Users;
use TheNetworg\OAuth2\Client\Provider\Azure;
use TheNetworg\OAuth2\Client\Token\AccessToken;

class AzureADAPIClient {
    public Azure $provider;

    //Resouces
    public Users $users;
    public Aplications $applications;
    public ServicePrincipals $service_principals;

    public function __construct(array $options) {
        $this->provider = new Azure($options);

        //Resouces
        $this->users = new Users($this->provider);
        $this->applications = new Aplications($this->provider);
        $this->service_principals = new ServicePrincipals($this->provider);
    }

    public function auth() {
        /** @var ?AccessToken $accessToken */
        $accessToken = request()->session()->get('access_token');

        if (!isset($accessToken)) {
            redirect:
            $authorizationUrl = $this->provider->getAuthorizationUrl(['scope' => $this->provider->scope]);
            request()->session()->put('OAuth2.state', $this->provider->getState());
            header("Location: $authorizationUrl");

        } else {
            if ($accessToken->hasExpired()) {
                if (!is_null($accessToken->getRefreshToken())) {
                    request()->session()->put(
                        'access_token',
                        $this->provider->getAccessToken('refresh_token', [
                            'scope'         => $this->provider->scope,
                            'refresh_token' => $accessToken->getRefreshToken()
                        ])
                    );
                } else {
                    request()->session()->forget('access_token');
                    goto redirect;
                }
            }
        }

    }
}
