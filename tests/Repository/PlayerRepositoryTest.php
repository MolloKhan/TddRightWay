<?php

namespace App\Tests\Repository;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerRepositoryTest extends WebTestCase
{
    // ZOMBIE (ZERO, ONE, MANY, BOUNDARIES, INTERFACES, EXCEPTIONS)
    // scoreboard with zero players
    // scoreboard with one player
    // scoreboard with many players
    // scoreboard shows no more than 5 players
    // scoreboard ordered by highest score
    // scoreboard is date range constrained to 15 days

    public function testGetScoreboard_withZeroPlayers()
    {
        self::bootKernel();

        /** @var PlayerRepository $repository */
        $repository = self::getContainer()->get(PlayerRepository::class);

        $scoreboard = $repository->getScoreboard();

        self::assertEmpty($scoreboard);
    }
}
