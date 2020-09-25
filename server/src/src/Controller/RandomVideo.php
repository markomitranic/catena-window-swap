<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RandomVideo extends AbstractController
{

	public function index()
	{
		return new Response('test');
	}

}
