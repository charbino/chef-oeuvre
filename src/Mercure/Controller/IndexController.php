<?php

namespace App\Mercure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/mercure', name: 'mercure_index')]
class IndexController extends AbstractController
{
    public function __invoke(): Response
    {

        return $this->render('mercure/index.html.twig', [

        ]);
    }
}
