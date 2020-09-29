<?php
declare(strict_types=1);

namespace App\OAuth2\Storage;

use DateTimeInterface;

interface Bucket
{

	public function getRefreshToken(): string;
	public function setRefreshToken(string $token): Bucket;
	public function getAccessToken(): string;
	public function setAccessToken(string $token, DateTimeInterface $expires): Bucket;

}
