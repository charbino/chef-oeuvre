<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'homepage')]
class HomepageController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(Request $request, SessionInterface $session): Response
    {
        return $this->render('homepage/homepage.html.twig');
    }
}
