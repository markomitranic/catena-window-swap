<?php
declare(strict_types=1);

namespace App\Submission\Request;

use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class Validator
{

	private const ALLOWED_MIME_TYPES = [
		"video/quicktime",
		"video/mp4",
		"video/avi",
		"video/mpeg",
		"video/mpg",
		"video/mov",
		"video/wmv",
		"video/rm",
		"video/x-flv",
		"video/mp4",
		"video/3gpp",
		"video/quicktime",
		"video/x-msvideo",
		"video/x-ms-wmv",
	];

	public function validate(Request $request): SubmissionDTO
	{
		$name = $request->get('name');
		$location = $request->get('location');
		$video = $request->files->get('video');

		$validator = Validation::createValidator();

		$violations = $validator->validate(
			$name,
			[
				new Length(['min' => 3, 'max' => 255]),
				new NotBlank(),
			]
		);
		if (0 !== count($violations)) {
			throw new Exception(sprintf(
				'Request validation failed: [%s] %s',
				'name',
				json_encode($this->getErrorMessages($violations)))
			);
		}

		$violations = $validator->validate(
			$location,
			[
				new Length(['min' => 3, 'max' => 255]),
				new NotBlank(),
			]
		);
		if (0 !== count($violations)) {
			throw new Exception(sprintf(
				'Request validation failed: [%s] %s',
				'location',
				json_encode($this->getErrorMessages($violations)))
			);
		}

		$violations = $validator->validate(
			$video,
			[
				new File([
					 'maxSize' => '2G',
					 'mimeTypes' => self::ALLOWED_MIME_TYPES,
					 'mimeTypesMessage' => 'Please upload a valid Video.',
				 ]),
			]
		);
		if (0 !== count($violations)) {
			throw new Exception(sprintf(
				'Request validation failed: [%s] %s',
				'video',
				json_encode($this->getErrorMessages($violations)))
			);
		}

		return new SubmissionDTO($name, $location, $video);
	}

	private function getErrorMessages(ConstraintViolationListInterface $violations) {
		$errors = array();
		/** @var ConstraintViolationInterface $violation */
		foreach ($violations as $violation) {
			$errors[$violation->getPropertyPath()] = $violation->getMessage();
		}
		return $errors;
	}

}
