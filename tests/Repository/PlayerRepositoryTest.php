<?php

namespace App\Tests\Repository;

use App\Entity\GameResult;
use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

    public function testGetScoreBoard_ignoresRecordsOlderThan15Days()
    {
        $this->createPlayerWithVictories('player1');

        $p2 = $this->createPlayer('p2');
        $gameResult = $this->createGameResult($p2, true);
        $gameResult->setCreatedAt(new \DateTimeImmutable('-16 days'));

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();
        
        self::assertCount(1, $scoreboard);
    }

    public function testGetScoreBoard_top5_integration()
    {
        $p1 = $this->createPlayerWithVictories('player1');
        $p2 = $this->createPlayerWithVictories('player2', 3);
        $p3 = $this->createPlayerWithVictories('player3', 2);
        $p4 = $this->createPlayerWithVictories('player4');
        $p5 = $this->createPlayerWithVictories('player5');
        $p6 = $this->createPlayerWithVictories('player6');

        $this->getEntityManager()->flush();

        $scoreboard = $this->repository->getScoreboard();

        self::assertCount(5, $scoreboard);
        $this->assertPositionAndScore($p2, 1, 3, $scoreboard);
        $this->assertPositionAndScore($p3, 2, 2, $scoreboard);
        $this->assertPositionAndScore($p1, 3, 1, $scoreboard);
        $this->assertPositionAndScore($p4, 4, 1, $scoreboard);
        $this->assertPositionAndScore($p5, 5, 1, $scoreboard);
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

    private function createPlayerWithVictories(string $nickname, int $quantity = 1): Player
    {
        $player = $this->createPlayer($nickname);
        for ($i = 0; $i < $quantity; $i++) {
            $this->createGameResult($player, true);
        }

        return $player;
    }

    private function assertPositionAndScore(Player $p2, int $position, int $score, $scoreboard): void
    {
        $position--;
        self::assertSame($p2, $scoreboard[$position][0]);
        self::assertEquals($score, $scoreboard[$position]['score']);
    }
}
