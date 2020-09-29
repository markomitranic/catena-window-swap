<?php
declare(strict_types=1);

namespace App\YouTube;

use App\OAuth2\OAuth2;
use Exception;
use Google_Http_MediaFileUpload;
use Google_Service_YouTube;
use Google_Service_YouTube_Video;
use Google_Service_YouTube_VideoSnippet;
use Google_Service_YouTube_VideoStatus;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VideoUploadService
{

	private const CHUNK_SIZE_BYTES = 1048576;
	public const CATEGORY_TRAVEL = 19;
	public const PRIVACY_UNLISTED = 'unlisted';
	private const ALLOWED_TYPES = [
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

	private Client $client;

	public function __construct(
		Client $client,
		OAuth2 $OAuth2
	) {
		$this->client = $client;
		$this->client->setAccessToken($OAuth2->getAccessToken());
	}

	public function upload(
		UploadedFile $uploadedFile,
		string $title,
		string $description
	): string {
		if (!in_array($uploadedFile->getMimeType(), self::ALLOWED_TYPES)) {
			throw new Exception('MIME type is not allowed');
		}

		$youtubeClient = new Google_Service_YouTube($this->client);

		$response = $youtubeClient->videos->insert(
			"status,snippet",
			$this->createVideoRecord($title, $description),
			array(
				'data' => file_get_contents($uploadedFile->getRealPath()),
				'mimeType' => 'application/octet-stream',
				'uploadType' => 'multipart'
			)
		);

		return $response->getId();
	}

	private function createVideoRecord(string $title, string $description): Google_Service_YouTube_Video {
		$snippet = new Google_Service_YouTube_VideoSnippet();
		$snippet->setTitle($title);
		$snippet->setDescription($description);
		$snippet->setTags([]);
		$snippet->setCategoryId(19);
		$status = new Google_Service_YouTube_VideoStatus();
		$status->setEmbeddable(true);
		$status->setPrivacyStatus('unlisted');
		$videoRecord = new Google_Service_YouTube_Video();
		$videoRecord->setSnippet($snippet);
		$videoRecord->setStatus($status);

		return $videoRecord;
	}

	private function send(UploadedFile $uploadedFile, Google_Http_MediaFileUpload $uploadRequest): array
	{
		$status = false;
		$handle = fopen($uploadedFile->getRealPath(), "rb");
		while (!$status && !feof($handle)) {
			$chunk = fread($handle, self::CHUNK_SIZE_BYTES);
			$status = $uploadRequest->nextChunk($chunk);
		}
		fclose($handle);

		if (!$status) {
			throw new Exception('Upload status is still false, even after we finished uploading.', 500);
		}

		return $status;
	}

}
