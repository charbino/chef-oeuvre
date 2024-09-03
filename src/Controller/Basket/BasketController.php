<?php

/*
 * This file is part of the EMS package.
 *
 * (c) NewQuest Entertainment
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Controller\Basket;

use App\Repository\Basket\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/basket', name: 'basket')]
class BasketController extends AbstractController
{
    public function __construct(
        private TeamRepository $teamRepository
    ) {
    }

    #[Route('/index', name: '_index')]
    public function index(): Response
    {
        return $this->render('basket/index.html.twig', [
            'teams' => $this->teamRepository->findAll(),
        ]);
    }
}
