<?php

namespace App\Service;

use App\Entity\Player;
use App\Mailer\PlayerMailer;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class TopPlayerService
{
    private PlayerRepository $playerRepository;
    private PlayerMailer $playerMailer;
    private EntityManagerInterface $entityManager;

    public function __construct(PlayerRepository $playerRepository, PlayerMailer $playerMailer, EntityManagerInterface $entityManager)
    {
        $this->playerRepository = $playerRepository;
        $this->playerMailer = $playerMailer;
        $this->entityManager = $entityManager;
    }

    public function reward()
    {
        $firstTopPlayer = $this->playerRepository->findTopPlayerForDay('-1');
        $secondTopPlayer = $this->playerRepository->findTopPlayerForDay('-2');
        $thirdTopPlayer = $this->playerRepository->findTopPlayerForDay('-3');

        if ($this->arePlayersEquals($firstTopPlayer, $secondTopPlayer)) {
            $firstTopPlayer->addHonorPoints(1);

            $this->entityManager->flush();
        }

        if ($this->arePlayersEquals($secondTopPlayer, $thirdTopPlayer)) {
            $secondTopPlayer->addHonorPoints(1);

            $this->entityManager->flush();
        }

        if ($this->arePlayersEquals($firstTopPlayer, $secondTopPlayer) && $this->arePlayersEquals($secondTopPlayer, $thirdTopPlayer)) {
            $this->playerMailer->sendTopPlayerEmail($firstTopPlayer);
        }
    }

    private function arePlayersEquals(?Player $firstTopPlayer, ?Player $secondTopPlayer): bool
    {
        return $firstTopPlayer && $firstTopPlayer === $secondTopPlayer;
    }
}
