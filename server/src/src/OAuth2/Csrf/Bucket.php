<?php
declare(strict_types=1);

namespace App\OAuth2\Csrf;

interface Bucket
{

	public function setToken(string $token): Bucket;
	public function isValid(string $token): bool;

}
