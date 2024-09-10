<?php

namespace App\Controller\Messenger;

use App\Message\TestNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[\Symfony\Component\Routing\Attribute\Route(path: '/messenger', name: 'messenger')]
class TestMessageController extends AbstractController
{
    #[\Symfony\Component\Routing\Attribute\Route('/test', name: '_test')]
    public function index(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new TestNotification('Look! I created a message!'));

        return $this->render('messenger/index.html.twig', [
            'controller_name' => 'TestMessageController',
        ]);
    }
}
