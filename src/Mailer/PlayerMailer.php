<?php

namespace App\Mailer;

use App\Entity\Player;
use Symfony\Component\Mailer\MailerInterface;

class PlayerMailer
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendTopPlayerEmail(Player $player)
    {
        // todo: implement me
    }
}
