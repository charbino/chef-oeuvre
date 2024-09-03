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

use App\Client\BasketClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/basket/stat-player', name: 'basket_stat_player')]
class StatPlayerController extends AbstractController
{
    public function __construct(
        private BasketClient $client,
    ) {
    }

    #[Route('/index/{id}', name: '_index', options: ['expose' => true], methods: ['GET'])]
    public function index(Request $request): Response
    {
        $id = (int) $request->attributes->get('id');

        $stats = $this->client->getStatPlayer($id);
        dump($stats);

        return new JsonResponse($stats);
    }
}
