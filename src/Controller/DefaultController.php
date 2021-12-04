<?php

namespace App\Controller;

use App\Mailer\PlayerMailer;
use App\Repository\PlayerRepository;
use App\Service\PlayerNotifier;
use App\Service\TopPlayerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(TopPlayerService $topPlayerService): Response
    {
        return $this->render('homepage.html.twig');
    }
}
