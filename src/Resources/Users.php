<?php

namespace Ejetar\AzureADAPIClient\Resources;

class Users extends Base {
	protected string $resource = 'users';

	public function create(array $data, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->post($this->ref(), $data, $accessToken, $headers);
	}

	public function list($params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->get($this->ref() . "?$params", $accessToken, $headers));
	}

	public function get($userPrincipalName, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->get($this->ref("/$userPrincipalName"), $accessToken, $headers);
	}

	public function update($userPrincipalName, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->delete($this->ref("/$userPrincipalName"), $accessToken, $headers);
	}

	public function delete(array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->delete($this->ref(), $accessToken, $headers);
	}

	public function assign($userPrincipalName, array $data, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->post($this->ref("/$userPrincipalName/appRoleAssignments"), $data, $accessToken, $headers);
	}

	public function unassign($userPrincipalName, $appRoleId, array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return $this->provider->delete($this->ref("/$userPrincipalName/appRoleAssignments/$appRoleId"), $accessToken, $headers);
	}

	public function assignments($userPrincipalName, $params = "", array $headers = [], $doNotWrap = false) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->get($this->ref("/$userPrincipalName/appRoleAssignments") . "?$params", $accessToken, $headers, $doNotWrap));
	}

	public function getObjects($tenant, $params = "", array $headers = []) {
		$accessToken = request()->session()->get('access_token');
		return collect($this->provider->getObjects($tenant, $this->ref() . "?$params", $accessToken, $headers));
	}
}
