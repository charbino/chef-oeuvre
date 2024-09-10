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

use App\Provider\GraphicsStatsPlayerProviderInterface;
use App\Provider\StatsPlayersProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/basket/players/comparator', name: 'basket_players_comparator')]
class PlayersComparatorController extends AbstractController
{
    public function __construct(
        private StatsPlayersProviderInterface $statsPlayersProvider,
        private GraphicsStatsPlayerProviderInterface $graphicsStatsPlayerProvider
    ) {
    }

    #[Route('/index', name: '_index', options: ['expose' => true], methods: ['GET'])]
    public function index(Request $request): Response
    {
        return $this->render('basket/comparator/index.html.twig');
    }

    #[Route('/compare', name: '_compare', options: ['expose' => true], methods: ['GET'])]
    public function compare(Request $request): JsonResponse
    {
        $idPlayers = $request->get('ids');
        $seasons = $request->get('seasons');

        if (empty($idPlayers) || empty($seasons)) {
            throw new \LogicException('Parameters not good');
        }

        $stats = $this->statsPlayersProvider->provide($idPlayers, $seasons);
        if ($stats === []) {
            return new JsonResponse([]);
        }

        return new JsonResponse([
            'graphic' => $this->graphicsStatsPlayerProvider->provide($stats),
        ]);
    }
}
