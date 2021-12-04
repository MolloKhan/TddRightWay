<?php

namespace App\Mailer;

use App\Entity\Player;

class PlayerMailerDebugDecorator extends PlayerMailer
{
    private int $sentEmails = 0;

    public function sendTopPlayerEmail(Player $player)
    {
        $this->sentEmails++;

        parent::sendTopPlayerEmail($player);
    }

    public function getSentEmails(): int
    {
        return $this->sentEmails;
    }
}
