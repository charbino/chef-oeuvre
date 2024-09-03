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

namespace App\Provider;

interface StatsPlayersProviderInterface
{
    public function provide(array $idPlayers, array $seasons): array;
}