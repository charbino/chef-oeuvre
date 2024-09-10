<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[\Symfony\Component\Routing\Attribute\Route('/user', name: 'user')]
class HomeUserController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/', name: '_home')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'HomeUserController',
        ]);
    }
}
