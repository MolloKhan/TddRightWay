<?php

namespace App\Controller;

use App\Mailer\PlayerMailer;
use App\Repository\PlayerRepository;
use App\Service\PlayerNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(): Response
    {
        return $this->render('homepage.html.twig');
    }
}
