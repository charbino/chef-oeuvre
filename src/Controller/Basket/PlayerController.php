<?php

declare(strict_types=1);

namespace App\Controller\Basket;

use App\Entity\Basket\Player;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/basket/player', name: 'basket_player')]
class PlayerController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ) {
    }

    #[Route('/add', name: '_add', options: ['expose' => true], methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $player = $this->serializer->deserialize($request->getContent(), Player::class, 'json', ['groups' => 'basket']);
        dump($player);
        dump($request->getContent());
        //TODO MAYBE USE VALIDATOR

        $this->entityManager->persist($player);
        $this->entityManager->flush();

        return new JsonResponse(['success']);
    }
}
