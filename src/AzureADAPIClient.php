<?php

namespace Ejetar\AzureADAPIClient;

use Ejetar\AzureADAPIClient\Resources\Aplications;
use Ejetar\AzureADAPIClient\Resources\ServicePrincipals;
use Ejetar\AzureADAPIClient\Resources\Users;
use Ejetar\AzureADAPIClient\Resources\Invitations;
use League\OAuth2\Client\Provider\AbstractProvider;
use TheNetworg\OAuth2\Client\Token\AccessToken;

class AzureADAPIClient {
    //Resouces
    public Users $users;
    public Aplications $applications;
    public ServicePrincipals $service_principals;
    public Invitations $invitations;

    public function __construct(public AbstractProvider $provider) {
        //Resouces
        $this->users = new Users($this->provider);
        $this->applications = new Aplications($this->provider);
        $this->service_principals = new ServicePrincipals($this->provider);
        $this->invitations = new Invitations($this->provider);
    }

    public function auth() {
        /** @var ?AccessToken $accessToken */
        $accessToken = request()->session()->get('access_token');

        if (!isset($accessToken)) {
            redirect:
            $authorizationUrl = $this->provider->getAuthorizationUrl();
            request()->session()->put('OAuth2.state', $this->provider->getState());
            return redirect()->to($authorizationUrl)->send();
//            header("Location: $authorizationUrl");
//            die();

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
