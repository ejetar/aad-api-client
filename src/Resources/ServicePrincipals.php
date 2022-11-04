<?php

namespace Ejetar\AzureADAPIClient\Resources;

class ServicePrincipals extends Base {
    protected string $resource = 'servicePrincipals';

    public function create(array $data, array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->post($this->ref(), $data, $accessToken, $headers);
    }

    public function list(array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->get($this->ref(),$accessToken,$headers);
    }

    public function get($userPrincipalName, array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->get($this->ref("/$userPrincipalName"),$accessToken,$headers);
    }

    public function update($userPrincipalName, array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->delete($this->ref("/$userPrincipalName"),$accessToken,$headers);
    }

    public function delete(array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->delete($this->ref(),$accessToken,$headers);
    }

    public function assignments($userPrincipalName, array $headers = []) {
        $accessToken = request()->session()->get('access_token');
        return $this->provider->get($this->ref("/$userPrincipalName/appRoleAssignments"),$accessToken,$headers);
    }
}
