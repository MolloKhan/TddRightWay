<?php

namespace App\Tests;

use App\Entity\GameResult;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

class WebTestCase extends BaseWebTestCase
{
    protected function createPlayerWithVictories(string $nickname, int $quantity = 1): Player
    {
        $player = $this->createPlayer($nickname);
        for ($i = 0; $i < $quantity; $i++) {
            $this->createGameResult($player, true);
        }

        return $player;
    }

    protected function createPlayer(string $nickname): Player
    {
        $player = new Player($nickname);
        $this->getEntityManager()->persist($player);

        return $player;
    }

    protected function createGameResult(Player $player, bool $victory): GameResult
    {
        $gameResult = new GameResult($player, $victory);
        $this->getEntityManager()->persist($gameResult);

        return $gameResult;
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::getContainer()->get(EntityManagerInterface::class);
    }
}
