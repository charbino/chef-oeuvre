<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UploadMessage;

#[\Symfony\Component\Messenger\Attribute\AsMessageHandler]
class UploadMessageHandler
{
    public function __invoke(UploadMessage $uploadMessage)
    {
        dd($uploadMessage);
    }
}
