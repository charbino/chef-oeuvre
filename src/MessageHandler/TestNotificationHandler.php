<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\TestNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class TestNotificationHandler
 * @package App\MessageHandler
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class TestNotificationHandler implements MessageHandlerInterface
{

    public function __invoke(TestNotification $message)
    {
        return $message->getTest();
    }


}
