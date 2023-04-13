<?php

namespace Ejetar\AzureADAPIClient\Resources;

class ServicePrincipals extends Base {
	protected string $resource = 'servicePrincipals';

	public function create(array $data, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->post($this->ref(), $data, $accessToken, $headers);
	}

	public function list(array $headers = [], $params = "", $doNotWrap = false) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->get($this->ref() . "?$params", $accessToken, $headers, $doNotWrap));
	}

	public function get($userPrincipalName, $params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->get($this->ref("/$userPrincipalName") . "?$params", $accessToken, $headers);
	}

	public function update($userPrincipalName, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->delete($this->ref("/$userPrincipalName"), $accessToken, $headers);
	}

	public function delete(array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->delete($this->ref(), $accessToken, $headers);
	}

	public function assignments($userPrincipalName, $params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->get($this->ref("/$userPrincipalName/appRoleAssignments") . "?$params", $accessToken, $headers));
	}

	public function appRoleAssignedTo($userPrincipalName, $params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->get($this->ref("/$userPrincipalName/appRoleAssignedTo") . "?$params", $accessToken, $headers));
	}

	public function getObjects($tenant, $params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->getObjects($tenant, $this->ref() . "?$params", $accessToken, $headers));
	}
}
