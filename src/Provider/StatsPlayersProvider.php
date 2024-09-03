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

use App\Client\BasketClient;
use App\Entity\Basket\Player;

class StatsPlayersProvider implements StatsPlayersProviderInterface
{
    public const DATA_FILTERED = ['pts'];

    public function __construct(
        private BasketClient $client
    ) {}

    public function provide(array $idPlayers, array $seasons): array
    {
        $stats = [];
        foreach ($idPlayers as $idPlayer) {
            $statsPlayer = [];
            $page = 1;
            $player = null;
            while ($page !== null) {
                $stat = $this->client->getStatPlayers(
                    [$idPlayer],
                    ['per_page' => 100, 'page' => $page]
//                    ['seasons' => $seasons, 'per_page' => 100, 'page' => $page]
                );
                $statsPlayer = [
                    ...$this->filterData($stat['data']),
                    ...$statsPlayer
                ];

                $meta = $stat['meta'];
                $page = $meta['next_cursor'] !== null ? $page = $meta['next_cursor'] : $page = null;

                if ($player === null) {
                    $player = $stat['data'][0]['player'] ?? null;
                }
            }

            //TODO ORDER BY DATE
            usort($statsPlayer, function($gameA, $gameB){

                return ($gameA['date'] < $gameB['date']) ? -1 : 1;
            });
            $stats[$idPlayer] = ['player' => $player, 'games' => $statsPlayer];
        }
        return $stats;
    }

    private function filterData(array $data): array
    {
        $dataFiltered = [];

        foreach ($data as $lineKey => $value) {
            $dataFiltered[$lineKey]['date'] = $value['game']['date'];
            foreach (self::DATA_FILTERED as $filterName) {
                $dataFiltered[$lineKey][$filterName] =  $value[$filterName];
            }
        }

        return $dataFiltered;
    }
}