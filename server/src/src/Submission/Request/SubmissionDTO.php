<?php
declare(strict_types=1);

namespace App\Submission\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class SubmissionDTO
{

	private string $name;
	private string $location;
	private UploadedFile $video;

	public function __construct(
		string $name,
		string $location,
		UploadedFile $video
	) {
		$this->setName($name);
		$this->setLocation($location);
		$this->setVideo($video);
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function getLocation(): ?string
	{
		return $this->location;
	}

	public function setLocation(string $location): self
	{
		$this->location = $location;
		return $this;
	}

	public function getVideo(): UploadedFile
	{
		return $this->video;
	}

	public function setVideo(UploadedFile $video): self
	{
		$this->video = $video;
		return $this;
	}

}
