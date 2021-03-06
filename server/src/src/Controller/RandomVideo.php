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

		if (empty($videos)) {
			return new JsonResponse(['success' => false, 'error'=> 'No videos in the Database.']);
		}
		return new JsonResponse(['success' => true, 'data' => $videos[array_rand($videos)]]);
	}

}
