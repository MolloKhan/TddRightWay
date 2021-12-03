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
}
