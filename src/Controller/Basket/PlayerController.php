<?php

declare(strict_types=1);

namespace App\Controller\Basket;

use App\Entity\Basket\Player;
use App\Repository\Basket\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route(path: '/basket/player', name: 'basket_player')]
class PlayerController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TeamRepository $teamRepository,
    ) {
    }

    #[Route('/add', name: '_add', options: ['expose' => true], methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $player = $serializer->deserialize($request->getContent(), Player::class, 'json', [
            AbstractNormalizer::GROUPS => 'basket',
            AbstractNormalizer::CALLBACKS => [
                'team' => function (array $value, string $entity, string $attributeName) {
                    return $this->teamRepository->find($value['id']);
                },
            ],
        ]);


        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return new JsonResponse(['success']);
    }
}
