<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\TestNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TestNotificationHandler
{
    public function __invoke(TestNotification $message): string
    {
        return $message->getTest();
    }
}
