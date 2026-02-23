<?php

declare(strict_types=1);

namespace App\Mercure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/mercure/publish', name: 'mercure_publish')]
class PublishController extends AbstractController
{
    public function __invoke(HubInterface $hub): Response
    {
        try {
            $update = new Update(
                '/fr/this-is-topic',
                json_encode(['message' => 'OutOfStock'])
            );

            $hub->publish($update);
        }catch (\Exception $exception){
            dd($exception);
        }


        return new Response('published!');
    }
}
