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

use App\Repository\Basket\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[\Symfony\Component\Routing\Attribute\Route(path: '/basket/players', name: 'basket_players')]
class PlayersController extends AbstractController
{
    public function __construct(
        private PlayerRepository $repository
    ) {
    }

    #[\Symfony\Component\Routing\Attribute\Route('/get', name: '_get', options: ['expose' => true], methods: ['GET'])]
    public function get(Request $request): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()], ['json' => new JsonEncoder()]);
        $players = $this->repository->findAll();

        dump($players);

        return new JsonResponse($serializer->serialize($players, 'json', [
            AbstractNormalizer::ALLOW_EXTRA_ATTRIBUTES => true,
        ]), json: true);
    }
}
