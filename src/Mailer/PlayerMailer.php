<?php

namespace App\Mailer;

use App\Entity\Player;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;

class PlayerMailer
{
    private Mailer $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTopPlayerEmail(Player $player)
    {
        // todo: implement me
    }
}
