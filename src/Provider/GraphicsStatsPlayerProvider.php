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

class GraphicsStatsPlayerProvider implements GraphicsStatsPlayerProviderInterface
{
    public function provide(array $stats): array
    {
        $labels = [];
        $datasets = [];

        foreach ($stats as $playerId => $stat) {
            $player = $stat['player'];
            $games = $stat['games'];
            $data = [];
            foreach ($games as $game) {
                $pts = $game['pts'];
                $date = new \DateTime($game['date']);

                $labels[] = $date->format('d/m/y');
                $data[] = $pts;
            }

            $dataset = [
                'label' => $player['first_name'] . ' ' . $player['last_name'],
                'data' => $data,
                'backgroundColor' => '#f87979',

            ];

            $datasets[] = $dataset;
        }

        return ['labels' => $labels, 'datasets' => $datasets];
    }
}