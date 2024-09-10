<?php

declare(strict_types=1);

namespace App\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CityClient
{
    public const URL = 'https://geo.api.gouv.fr/';

    public const URL_COMMUNES = 'communes';
    public const URL_DEPARMENTS = 'departements';

    public const PARAMETER_NAME = 'nom';
    public const PARAMETER_POSTCODE = 'codePostal';
    public const PARAMETER_CODE = 'code';
    public const PARAMETER_DEPARTMENT_CODE = 'codeDepartement';
    public const PARAMETER_FORMAT = 'format';
    public const PARAMETER_GEOMETRY = 'geometry';

    public const VALUE_GEOJSON = 'geojson';
    public const PARAMETER_CONTOUR = 'contour';

    public function __construct(
        private HttpClientInterface $client,
    )
    {
        $this->client = $this->client->withOptions([
            'base_uri' => self::URL,
        ]);
    }

    /**
     * @return string[]
     */
    protected function getFields(): array
    {
        return ['fields' => 'nom,code,centre,codesPostaux,departement'];
    }

    /**
     * @param string $parameter
     * @param string $value
     * @return array<mixed>
     */
    public function getDeparmentsBy(string $parameter, string $value): array
    {
        $queryParam = array_merge([$parameter => $value], $this->getFields());
        $response = $this->client->request('GET', self::URL_DEPARMENTS, ['query' => $queryParam]);
        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return $response->toArray();
    }

    /**
     * @param string $name
     * @return array<mixed>
     */
    public function getDepartmentByName(string $name): array
    {
        return $this->getDeparmentsBy(self::PARAMETER_NAME, $name);
    }

    /**
     * @param string $code
     * @return mixed[]
     */
    public function getDepartmentByCode(string $code): array
    {
        return $this->getDeparmentsBy(self::PARAMETER_CODE, $code);
    }

    /**
     * @param array<string, string> $parameters
     * @return array<mixed>
     */
    public function getCitiesBy(array $parameters): array
    {
        $queryParam = array_merge($parameters, $this->getFields());
        $response = $this->client->request('GET', self::URL_COMMUNES, ['query' => $queryParam]);
        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return $response->toArray();
    }

    /**
     * @param string $name
     * @return array<mixed>
     */
    public function getCitiesByName(string $name): array
    {
        return $this->getCitiesBy([self::PARAMETER_NAME => $name]);
    }

    /**
     * @param string $postCode
     * @return array<mixed>
     */
    public function getCitiesByCodePostal(string $postCode): array
    {
        return $this->getCitiesBy([self::PARAMETER_POSTCODE => $postCode]);
    }

    /**
     * @param string $departmentCode
     * @return array<mixed>
     */
    public function getCitiesByDepartmentCode(string $departmentCode): array
    {
        return $this->getCitiesBy([self::PARAMETER_DEPARTMENT_CODE => $departmentCode]);
    }

    /**
     * @param string $departmentCode
     * @return array<mixed>
     */
    public function getCitiesInformationsByDepartmentCode(string $departmentCode): array
    {
        //        https://geo.api.gouv.fr/departements/73/communes?format=geojson&geometry=contour
        return $this->getCitiesBy(
            [
                self::PARAMETER_DEPARTMENT_CODE => $departmentCode,
                self::PARAMETER_FORMAT => self::VALUE_GEOJSON,
                self::PARAMETER_GEOMETRY => self::PARAMETER_CONTOUR,
            ]
        );
    }
}
