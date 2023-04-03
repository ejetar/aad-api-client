<?php

namespace Ejetar\AzureADAPIClient\Resources;

class Invitations extends Base {
    protected string $resource = 'invitations';

    public function create(array $data, array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->post($this->ref(), $data, $accessToken, $headers);
    }
}
