<?php
declare(strict_types=1);

namespace App\OAuth2\Csrf;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionBucket implements Bucket
{

	private const SESSION_KEY = 'oauth2state';

	private SessionInterface $session;

	public function __construct(RequestStack $requestStack)
	{
		$this->session = $requestStack->getCurrentRequest()->getSession();
	}

	public function setToken(string $token): Bucket
	{
		$this->session->set(self::SESSION_KEY, $token);
		return $this;
	}

	public function isValid(string $token): bool
	{
		$savedState = $this->session->get(self::SESSION_KEY);
		$this->session->remove(self::SESSION_KEY);
		return ($savedState === $token);
	}
}
