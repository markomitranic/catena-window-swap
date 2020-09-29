<?php
declare(strict_types=1);

namespace App\YouTube;

use Google_Client;
use Google_Service_YouTube;
use League\OAuth2\Client\Provider\Google;

class Client extends Google_Client
{

	private const ACCESS_TYPE_OFFLINE = 'offline';

	public function __construct(
		string $clientId,
		string $clientSecret,
		string $callbackUrl
	) {
		parent::__construct([]);

		$this->setClientId($clientId);
		$this->setClientSecret($clientSecret);
		$this->addScope([Google_Service_YouTube::YOUTUBE_UPLOAD]);
		$this->setRedirectUri($callbackUrl);
		$this->setAccessType(self::ACCESS_TYPE_OFFLINE);
	}

	public function getOauthProvider(): Google
	{
		return new Google([
			'clientId' => $this->getClientId(),
			'clientSecret' => $this->getClientSecret(),
			'redirectUri' => $this->getRedirectUri(),
			'accessType' => self::ACCESS_TYPE_OFFLINE,
			'scopes' => $this->getScopes()
	   ]);
	}

}
