<?php

namespace App\Tests\Service;

use App\Entity\Player;
use App\Mailer\PlayerMailer;
use App\Mailer\PlayerMailerDebugDecorator;
use App\Repository\PlayerRepository;
use App\Service\TopPlayerService;
use App\Tests\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class TopPlayerServiceTest extends WebTestCase
{
    /**
     * @var PlayerRepository|\PHPUnit\Framework\MockObject\MockObject
     */
    private $playerRepositoryMock;

    /**
     * @var PlayerMailer|\PHPUnit\Framework\MockObject\MockObject
     */
    private $playerMailerServiceMock;

    /**
     * @var EntityManagerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    private $entityManagerMock;

    protected function setUp(): void
    {
        $this->playerRepositoryMock = $this->createMock(PlayerRepository::class);
        $this->playerMailerServiceMock = $this->createMock(PlayerMailer::class);
        $this->entityManagerMock = $this->createMock(EntityManagerInterface::class);
    }

    public function testReward_zeroTopPlayersFound()
    {
        $this->playerRepositoryMock->expects($this->atLeastOnce())
            ->method('findTopPlayerForDay');

        $this->playerMailerServiceMock->expects($this->never())
            ->method('sendTopPlayerEmail');

        $this->entityManagerMock->expects($this->never())
            ->method('flush');

        $this->reward();
    }

    public function testReward_topPlayerForTwoConsecutiveDays()
    {
        $topPlayer = new Player('player 1');
        $this->playerRepositoryMock->expects($this->atLeastOnce())
            ->method('findTopPlayerForDay')
            ->willReturnMap([
                ['-1', $topPlayer],
                ['-2', $topPlayer]
            ]);

        $this->playerMailerServiceMock->expects($this->never())
            ->method('sendTopPlayerEmail');

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->reward();

        self::assertEquals(1, $topPlayer->getHonorPoints());
    }

    public function testReward_topPlayerForTwoConsecutiveDays_thirdAndSecondDays()
    {
        $topPlayer = new Player('player 1');
        $this->playerRepositoryMock->expects($this->atLeastOnce())
            ->method('findTopPlayerForDay')
            ->willReturnMap([
                ['-2', $topPlayer],
                ['-3', $topPlayer]
            ]);

        $this->playerMailerServiceMock->expects($this->never())
            ->method('sendTopPlayerEmail');

        $this->entityManagerMock->expects($this->once())
            ->method('flush');

        $this->reward();

        self::assertEquals(1, $topPlayer->getHonorPoints());
    }

    public function testReward_topPlayerFor3DaysInRow()
    {
        $topPlayer = new Player('player 1');
        $this->playerRepositoryMock->expects($this->atLeastOnce())
            ->method('findTopPlayerForDay')
            ->willReturnMap([
                ['-1', $topPlayer],
                ['-2', $topPlayer],
                ['-3', $topPlayer]
            ]);

        $this->playerMailerServiceMock->expects($this->atLeastOnce())
            ->method('sendTopPlayerEmail')
            ->with($topPlayer);

        $this->entityManagerMock->expects($this->atLeastOnce())
            ->method('flush');

        $this->reward();

        self::assertEquals(2, $topPlayer->getHonorPoints());
    }

    public function testIntegration()
    {
        self::bootKernel();

        $topPlayer = $this->createPlayer('Player 1');
        $threeDaysAgoVictory = $this->createGameResult($topPlayer, true);
        $threeDaysAgoVictory->setCreatedAt(new \DateTimeImmutable('-3 days'));

        $twoDaysAgoVictory = $this->createGameResult($topPlayer, true);
        $twoDaysAgoVictory->setCreatedAt(new \DateTimeImmutable('-2 days'));

        $oneDaysAgoVictory = $this->createGameResult($topPlayer, true);
        $oneDaysAgoVictory->setCreatedAt(new \DateTimeImmutable('-1 days'));

        $this->getEntityManager()->flush();

        $topPlayerService = self::getContainer()->get(TopPlayerService::class);
        $topPlayerService->reward();

        self::assertEquals(2, $topPlayer->getHonorPoints());

        /** @var PlayerMailerDebugDecorator $playerMailer */
        $playerMailer = self::getContainer()->get(PlayerMailer::class);
        self::assertEquals(1, $playerMailer->getSentEmails());
    }

    private function reward(): void
    {
        $topPlayerService = new TopPlayerService($this->playerRepositoryMock, $this->playerMailerServiceMock, $this->entityManagerMock);
        $topPlayerService->reward();
    }
}
