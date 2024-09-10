<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UploadMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UploadMessageHandler
{
    public function __invoke(UploadMessage $uploadMessage): void
    {
        dd($uploadMessage);
    }
}
