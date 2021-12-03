<?php

namespace App\Tests\Service;

use App\Entity\Player;
use App\Mailer\PlayerMailer;
use App\Repository\PlayerRepository;
use App\Service\TopPlayerService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TopPlayerServiceTest extends TestCase
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

    public function testReward_oneTopPlayer()
    {
        $topPlayer = new Player('player 1');
        $this->playerRepositoryMock->expects($this->atLeastOnce())
            ->method('findTopPlayerForDay')
            ->willReturnMap([
                '-1', $topPlayer
            ]);

        $this->playerMailerServiceMock->expects($this->never())
            ->method('sendTopPlayerEmail');

        $this->entityManagerMock->expects($this->never())
            ->method('flush');

        $this->reward();
    }

    private function reward(): void
    {
        $topPlayerService = new TopPlayerService($this->playerRepositoryMock, $this->playerMailerServiceMock, $this->entityManagerMock);
        $topPlayerService->reward();
    }
}
