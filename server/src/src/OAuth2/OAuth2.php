<?php
declare(strict_types=1);

namespace App\OAuth2;

use App\OAuth2\Csrf\Bucket as CsrfBucket;
use App\OAuth2\Storage\Bucket as TokenBucket;
use DateTimeImmutable;
use Exception;
use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\AbstractProvider;
use Throwable;

class OAuth2
{

	private AbstractProvider $provider;
	private TokenBucket $tokenBucket;
	private CsrfBucket $csrfBucket;

	public function __construct(
		AbstractProvider $provider,
		TokenBucket $tokenBucket,
		CsrfBucket $csrfBucket
	) {
		$this->provider = $provider;
		$this->tokenBucket = $tokenBucket;
		$this->csrfBucket = $csrfBucket;
	}

	public function getAuthorizationUrl(): string
	{
		$authorizationUrl = $this->provider->getAuthorizationUrl(['prompt' => 'consent']);
		$this->csrfBucket->setToken($this->provider->getState());
		return $authorizationUrl;
	}

	public function verifyState(string $callbackState): bool
	{
		if (!$this->csrfBucket->isValid($callbackState)) {
			throw new Exception('State is invalid, possible CSRF attack in progress.');
		}
		return true;
	}

	public function exchangeCodeForToken(string $code): string
	{
		$token = $this->provider->getAccessToken('authorization_code', ['code' => $code]);

		$this->tokenBucket->setRefreshToken($token->getRefreshToken());
		$this->tokenBucket->setAccessToken(
			$token->getToken(),
			new DateTimeImmutable('@' . $token->getExpires())
		);

		return $token->getToken();
	}

	public function getAccessToken(): string
	{
		try {
			return $this->tokenBucket->getAccessToken();
		} catch (Throwable $exception) {
			return $this->refreshAccessToken();
		}
	}

	private function refreshAccessToken(): string
	{
		$token = $this->provider->getAccessToken(
			new RefreshToken(),
			['refresh_token' => $this->tokenBucket->getRefreshToken()]
		);
		$this->tokenBucket->setAccessToken(
			$token->getToken(),
			new DateTimeImmutable('@' . $token->getExpires())
		);
		return $token->getToken();
	}

}
