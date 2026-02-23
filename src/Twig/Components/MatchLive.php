<?php

/*
 * This file is part of the EMS package.
 *
 * (c) NewQuest Entertainment
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Twig\Components;

use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
class MatchLive
{
    use DefaultActionTrait;

    #[LiveProp]
    public string $topic;

    #[LiveProp(writable: true)]
    public string $message = '';

    #[LiveAction]
    public function sendMessage(HubInterface $hub): void
    {
        $update = new Update(
            $this->topic,
            json_encode([
                'message' => $this->message
            ], JSON_THROW_ON_ERROR),
        );

        $hub->publish($update);
    }
}
