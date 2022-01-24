<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\UploadMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class UploadMessageHandler
 * @package App\MessageHandler
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class UploadMessageHandler implements MessageHandlerInterface
{
    public function __invoke(UploadMessage $uploadMessage)
    {
        dd($uploadMessage);
    }

}
