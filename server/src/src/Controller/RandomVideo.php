<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RandomVideo extends AbstractController
{

	public function index(VideoRepository $videoRepository): JsonResponse
	{
		$videos = $videoRepository->findAll();
		return new JsonResponse($videos[array_rand($videos)]);
	}

}
