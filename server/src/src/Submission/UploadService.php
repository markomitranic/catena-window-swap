<?php
declare(strict_types=1);

namespace App\Submission;

use App\Entity\Submission;
use App\Submission\Request\SubmissionDTO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadService
{

	private SluggerInterface $slugger;
	private EntityManagerInterface $entityManager;
	private string $videosDirPath;

	public function __construct(
		SluggerInterface $slugger,
		EntityManagerInterface $entityManager,
		string $videosDirPath
	) {
		$this->slugger = $slugger;
		$this->entityManager = $entityManager;
		$this->videosDirPath = $videosDirPath;
	}

	public function submit(SubmissionDTO $submissionDTO): Submission
	{
		$newFilename = $this->generateFilename($submissionDTO->getVideo());
		$submissionDTO->getVideo()->move($this->videosDirPath, $newFilename);

		$submission = new Submission();
		$submission
			->setName($submissionDTO->getName())
			->setLocation($submissionDTO->getLocation())
			->setVideoFilename($newFilename);

		$this->entityManager->persist($submission);
		$this->entityManager->flush();

		return $submission;
	}

	private function generateFilename(UploadedFile $uploadedFile): string
	{
		$safeFilename = $this->slugger->slug(pathinfo(
			$uploadedFile->getClientOriginalName(),
			PATHINFO_FILENAME
		));
		return sprintf('%s-%s.%s', $safeFilename, uniqid(), $uploadedFile->guessExtension());
	}

}
