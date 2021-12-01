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

    public function testGetScoreboard_withManyPlayer()
    {
        $player = $this->createPlayer('player');
        $player2 = $this->createPlayer('player2');
        $gameResult = $this->createGameResult($player, true);
        $gameResult2 = $this->createGameResult($player2, true);

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();

        self::assertCount(2, $scoreboard);
    }

    public function testGetScoreboard_limitsTo5Players()
    {
        $this->createPlayerWithVictory('player1');
        $this->createPlayerWithVictory('player2');
        $this->createPlayerWithVictory('player3');
        $this->createPlayerWithVictory('player4');
        $this->createPlayerWithVictory('player5');
        $this->createPlayerWithVictory('player6');

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();

        self::assertCount(5, $scoreboard);
    }

    private function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }

    private function createPlayer(string $nickname): Player
    {
        $player = new Player($nickname);
        $this->getEntityManager()->persist($player);

        return $player;
    }

    private function createGameResult(Player $player, bool $victory): GameResult
    {
        $gameResult = new GameResult($player, $victory);
        $this->getEntityManager()->persist($gameResult);

        return $gameResult;
    }

    private function createPlayerWithVictory(string $nickname): Player
    {
        $player = $this->createPlayer($nickname);
        $this->createGameResult($player, true);

        return $player;
    }
}
