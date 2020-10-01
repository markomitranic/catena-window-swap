<?php
declare(strict_types=1);

namespace App\Controller;

use App\Submission\Request\Validator;
use App\Submission\UploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubmitVideo extends AbstractController
{

	public function index(
		Validator $validator,
		UploadService $uploadService,
		Request $request
	): Response {
		try {
			$submissionDto = $validator->validate(
				$request->get('name'),
				$request->get('location'),
				$request->files->get('video')
			);
		} catch (\Throwable $e) {
			return new JsonResponse(['success' => false, 'error' => $e->getMessage()], 400);
		}

		$uploadService->submit($submissionDto);
		return new JsonResponse(['success' => true]);
	}

}
