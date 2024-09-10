<?php

declare(strict_types=1);

namespace App\Controller\Basket;

use App\Client\BasketClient;
use App\Transformer\Basket\PlayerBasketTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/basket/search', name: 'basket_player')]
class SearchPlayerController extends AbstractController
{
    public function __construct(
        private BasketClient $client,
        private PlayerBasketTransformerInterface $transformer
    )
    {
    }

    #[Route('/index', name: '_search', options: ['expose' => true], methods: ['GET'])]
    public function index(Request $request): Response
    {
        $query = $request->query->get('query', '');
        $limit = $request->query->get('limit', '25');

        if (!$request->isXmlHttpRequest()) {
            return $this->render('basket/search/search.html.twig', ['query' => $query]);
        }

        $playersApi = $this->client->getPlayers($query, 0, (int) $limit);
        $players = [];
        foreach ($playersApi as $playerData) {
            $players[] = $this->transformer->transform($playerData);
        }

        $serializer = new Serializer([new GetSetMethodNormalizer()], ['json' => new JsonEncoder()]);

        return new JsonResponse(
            $serializer->serialize(['players' => $players], 'json', [
                AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            ]), json: true);
    }
}
