<?php
declare(strict_types=1);

namespace App\OAuth2\Controller;

use App\OAuth2\OAuth2;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Consent extends AbstractController
{

	private LoggerInterface $logger;
	private OAuth2 $facade;

	public function __construct(
		LoggerInterface $logger,
		OAuth2 $facade
	) {
		$this->logger = $logger;
		$this->facade = $facade;
	}

	public function consent(): Response {
		return new RedirectResponse($this->facade->getAuthorizationUrl(), 302);
	}

	public function callback(Request $request): Response
	{
		if (!empty($request->get('error'))) {
			$this->logger->error(
				'User returned from OAuth consent form with an error.',
				['message' => $request->get('error')]
			);
			return new JsonResponse(['error' => $request->get('error')], 403);
		}

		try {
			$this->facade->verifyState($request->get('state'));
		} catch (Throwable $exception) {
			$this->logger->error(
				'State is invalid, possible CSRF attack in progress.',
				['callbackState' => $request->get('state'), 'exception' => $exception]
			);
			return new JsonResponse(['error' => 'Invalid CSRF state.'], 403);
		}

		try {
			$token = $this->facade->exchangeCodeForToken($request->get('code'));
			return new JsonResponse(['token' => $token]);
		} catch (Throwable $exception) {
			$this->logger->error(
				'Code exchange for Tokens failed.',
				['state' => $request->get('code'), 'exception' => $exception]
			);
			return new JsonResponse(['error' => 'Code exchange for Tokens failed.'], 403);
		}
	}

}
