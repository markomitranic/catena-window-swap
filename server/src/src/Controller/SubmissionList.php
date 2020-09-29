<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\SubmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SubmissionList extends AbstractController
{

	private string $siteUrl;
	private string $videosDirPath;

	public function __construct(string $siteUrl, string $videosDirPath)
	{
		$this->siteUrl = $siteUrl;
		$this->videosDirPath = $videosDirPath;
	}

	public function index(SubmissionRepository $repository): Response
	{
		$submissions = $repository->findAll();

		$output = [];
		foreach ($submissions as $submission) {
			$output[] = [
				'id' => $submission->getId(),
				'name' => $submission->getName(),
				'location' => $submission->getLocation(),
				'video' => $this->getPublicVideoUrl($submission->getVideoFilename())
			];
		}

		return new JsonResponse(['success' => true, 'data' => $output]);
	}

	private function getPublicVideoUrl(string $fileName): string
	{
		return sprintf(
			'%s/%s/%s',
			$this->siteUrl,
			$this->videosDirPath,
			$fileName
		);
	}

}
