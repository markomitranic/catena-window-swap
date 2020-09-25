<?php
declare(strict_types=1);

namespace App\Video;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Faker\Provider\Youtube;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SeedCommand extends Command
{

	private const NAME = 'fixtures:populate';
	private EntityManagerInterface $em;
	private Generator $faker;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->em = $entityManager;
		$this->faker = Factory::create();
		$this->faker->addProvider(new Youtube($this->faker));
		parent::__construct(self::NAME);
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new ConsoleStyle($input, $output);
		$io->writeln('Generating random videos...');
		for ($i=0; $i < 10; $i++) {
			$this->em->persist(
				(new Video())
					->setYoutubeId($this->getYoutubeId())
					->setName($this->faker->name)
					->setLocation($this->faker->city)
			);
		}

		$this->em->flush();
		return 0;
	}

	private function getYoutubeId(): string
	{
		$randomUri = $this->faker->youtubeUri();
		parse_str(parse_url($randomUri)['query'], $queryArray);
		return $queryArray['v'];
	}

}
