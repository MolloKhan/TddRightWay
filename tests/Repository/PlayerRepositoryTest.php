<?php

namespace App\Tests\Repository;

use App\Repository\GameResultRepository;
use App\Repository\PlayerRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerRepositoryTest extends WebTestCase
{
    public function testSetup()
    {
        self::bootKernel();

        $repository = self::getContainer()->get(PlayerRepository::class);

        self::assertInstanceOf(PlayerRepository::class, $repository);
    }
}
