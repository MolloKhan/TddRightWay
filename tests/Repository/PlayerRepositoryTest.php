<?php

namespace App\Tests\Repository;

use App\Entity\GameResult;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
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

    public function testGetScoreboard_withOnePlayer()
    {
        self::bootKernel();

        $player = new Player('player');
        $gameResult = new GameResult($player, true);

        $em = self::getContainer()->get(EntityManagerInterface::class);
        $em->persist($player);
        $em->persist($gameResult);
        $em->flush();

        /** @var PlayerRepository $repository */
        $repository = self::getContainer()->get(PlayerRepository::class);

        $scoreboard = $repository->getScoreboard();

        self::assertCount(1, $scoreboard);
    }
}
