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

namespace App\Transformer\City;

use App\Model\City\City;
use App\Model\City\CityProperties;

class CitiesTransformer
{
    /**
     * @param array<string,mixed> $data
     *
     * @return City[]
     */
    public function transform(array $data): array
    {
        $cities = [];
        foreach ($data as $cityData) {
            if (!isset($cityData['properties'])) {
                continue;
            }

            $cities[] = new City(
                $cityData['id'],
                $cityData['geometry'],
                $cityData['geometry_name'],
                new CityProperties(
                    $cityData['properties']['nom_com'],
                    $cityData['properties']['code_dep'],
                    $cityData['properties']['code_insee'],
                ),
                $cityData['bbox'],
            );
        }

        return $cities;
    }
}
