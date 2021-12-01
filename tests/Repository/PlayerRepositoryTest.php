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

    public function testGetScoreBoard_ignoresRecordsOlderThan15Days()
    {
        $this->createPlayerWithVictory('player1');
        $p2 = $this->createPlayer('p2');
        $gameResult = $this->createGameResult($p2, true);
        $gameResult->setCreatedAt(new \DateTimeImmutable('-16 days'));

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();
        
        self::assertCount(1, $scoreboard);
    }

    public function testGetScoreBoard_top5_integration()
    {
        $p1 = $this->createPlayerWithVictory('player1');

        $p2 = $this->createPlayerWithVictory('player2');
        $this->createGameResult($p2, true);
        $this->createGameResult($p2, true);

        $p3 = $this->createPlayerWithVictory('player3');
        $this->createGameResult($p3, true);

        $p4 = $this->createPlayerWithVictory('player4');
        $p5 = $this->createPlayerWithVictory('player5');
        $p6 = $this->createPlayerWithVictory('player6');

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();

        self::assertCount(5, $scoreboard);
        self::assertSame($p2, $scoreboard[0][0]);
        self::assertEquals(3, $scoreboard[0]['score']);
        self::assertSame($p3, $scoreboard[1][0]);
        self::assertEquals(2, $scoreboard[1]['score']);
        self::assertSame($p1, $scoreboard[2][0]);
        self::assertEquals(1, $scoreboard[2]['score']);
        self::assertSame($p4, $scoreboard[3][0]);
        self::assertEquals(1, $scoreboard[3]['score']);
        self::assertSame($p5, $scoreboard[4][0]);
        self::assertEquals(1, $scoreboard[4]['score']);
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
