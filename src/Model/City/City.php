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

namespace App\Model\City;

final class City
{
    /**
     * @param string $id
     * @param array<mixed> $geometry
     * @param string $geometry_name
     * @param CityProperties $properties
     * @param array<mixed> $bbox
     */
    public function __construct(
        public string $id,
        public array $geometry,
        public string $geometry_name,
        public CityProperties $properties,
        public array $bbox
    ) {
    }

    public function getCodeInsee(): ?string
    {
        return $this->properties->codeInsee;
    }
}
