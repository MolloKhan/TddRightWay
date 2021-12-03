<?php

namespace App\Service;

use App\Mailer\PlayerMailer;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;

class TopPlayerService
{
    private PlayerRepository $playerRepository;
    private PlayerMailer $playerMailerService;
    private EntityManagerInterface $entityManager;

    public function __construct(PlayerRepository $playerRepository, PlayerMailer $playerMailerService, EntityManagerInterface $entityManager)
    {
        $this->playerRepository = $playerRepository;
        $this->playerMailerService = $playerMailerService;
        $this->entityManager = $entityManager;
    }

    public function reward()
    {
        $firstTopPlayer = $this->playerRepository->findTopPlayerForDay('-1');
        $secondTopPlayer = $this->playerRepository->findTopPlayerForDay('-2');
        $thirdTopPlayer = $this->playerRepository->findTopPlayerForDay('-3');

        if ($firstTopPlayer && $firstTopPlayer === $secondTopPlayer) {
            $firstTopPlayer->addHonorPoints(1);

            $this->entityManager->flush();
        }

        if ($secondTopPlayer && $secondTopPlayer === $thirdTopPlayer) {
            $secondTopPlayer->addHonorPoints(1);

            $this->entityManager->flush();
        }
    }
}
