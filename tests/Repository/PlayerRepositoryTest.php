<?php

namespace App\Tests\Repository;

use App\Entity\GameResult;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// ZOMBIE (ZERO, ONE, MANY, BOUNDARIES, INTERFACES, EXCEPTIONS)
// scoreboard with zero players
// scoreboard with one player
// scoreboard with many players
// scoreboard shows no more than 5 players
// scoreboard ordered by highest score
// scoreboard is date range constrained to 15 days
class PlayerRepositoryTest extends WebTestCase
{
    private PlayerRepository $repository;

    public function setUp(): void
    {
        self::bootKernel();

        $this->repository = self::getContainer()->get(PlayerRepository::class);
    }

    public function testGetScoreboard_withZeroPlayers()
    {
        $scoreboard = $this->repository->getScoreboard();

        self::assertEmpty($scoreboard);
    }

    public function testGetScoreboard_withOnePlayer()
    {
        $player = new Player('player');
        $gameResult = new GameResult($player, true);

        $em = $this->getEntityManager();
        $em->persist($player);
        $em->persist($gameResult);
        $em->flush();

        $scoreboard = $this->repository->getScoreboard();

        self::assertCount(1, $scoreboard);
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }
}
