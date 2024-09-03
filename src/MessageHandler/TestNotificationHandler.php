<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\TestNotification;

#[\Symfony\Component\Messenger\Attribute\AsMessageHandler]
class TestNotificationHandler
{
    public function __invoke(TestNotification $message)
    {
        return $message->getTest();
    }
}
