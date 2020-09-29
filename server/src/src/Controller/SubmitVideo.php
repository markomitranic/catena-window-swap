<?php
declare(strict_types=1);

namespace App\Controller;

use App\YouTube\VideoUploadService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SubmitVideo extends AbstractController
{

	public function index(Request $request, VideoUploadService $uploadService): JsonResponse
	{
		$filesBag = $request->files->all();
		if (!array_key_exists('video', $filesBag)) {
			throw new \Exception('No video attached', 400);
		}

		$uploadService->upload($filesBag['video'], $request->get('name'), $request->get('location'));

		return new JsonResponse(true);
	}

}
