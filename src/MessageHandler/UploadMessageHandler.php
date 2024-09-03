<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UploadMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

#[\Symfony\Component\Messenger\Attribute\AsMessageHandler]
class UploadMessageHandler
{
    public function __invoke(UploadMessage $uploadMessage)
    {
        dd($uploadMessage);
    }
}
