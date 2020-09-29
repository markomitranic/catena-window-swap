<?php
declare(strict_types=1);

namespace App\OAuth2\Storage;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CacheBucket implements Bucket
{

	private const KEY_ACCESS_TOKEN = 'access_token';
	private const KEY_REFRESH_TOKEN = 'refresh_token';

	private AdapterInterface $adapter;

	public function __construct(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	public function getRefreshToken(): string
	{
		return $this->adapter->get(
			self::KEY_REFRESH_TOKEN,
			function () { throw new Exception('No refresh token stored within the cache mechanism.');}
		);
	}

	public function setRefreshToken(string $token): Bucket
	{
		$this->adapter->delete(self::KEY_REFRESH_TOKEN);
		$this->adapter->get(
			self::KEY_REFRESH_TOKEN,
			function (ItemInterface $item) use ($token) {
				$item->expiresAfter(null);
				$item->set($token);
				return $token;
			}
		);

		$marko = $this->getRefreshToken();

		return $this;
	}

	public function getAccessToken(): string
	{
		return $this->adapter->get(
			self::KEY_ACCESS_TOKEN,
			function () { throw new Exception('No access token stored within the cache mechanism.');}
		);
	}

	public function setAccessToken(string $token, DateTimeInterface $expiresAt): Bucket
	{
		$this->adapter->delete(self::KEY_ACCESS_TOKEN);
		$this->adapter->get(
			self::KEY_ACCESS_TOKEN,
			function (ItemInterface $item) use ($token, $expiresAt) {
				$item->expiresAfter($expiresAt->diff(new DateTimeImmutable(), true));
				$item->set($token);
				return $token;
			}
		);
		return $this;
	}
}
