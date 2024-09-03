<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class CityClient extends Client
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

    public function __construct(array $config = [])
    {
        $config['base_uri'] = self::URL;

        parent::__construct($config);
    }

    /**
     * @return string[]
     */
    protected function getFields(): array
    {
        return ['fields' => 'nom,code,centre,codesPostaux,departement'];
    }

    /**
     * @return mixed|null
     */
    public function getDeparmentsBy(string $parameter, string $value)
    {
        $queryParam = array_merge([$parameter => $value], $this->getFields());
        $result = $this->request('GET', self::URL_DEPARMENTS, ['query' => $queryParam]);
        if ($result->getStatusCode() != 200) {
            return null;
        }

        return json_decode($result->getBody()->getContents());
    }

    /**
     * @return mixed| ResponseInterface
     */
    public function getDepartmentByName(string $name)
    {
        return $this->getDeparmentsBy(self::PARAMETER_NAME, $name);
    }

    /**
     * @return mixed| ResponseInterface
     */
    public function getDepartmentByCode(string $code)
    {
        return $this->getDeparmentsBy(self::PARAMETER_CODE, $code);
    }

    /**
     * @return mixed|null
     */
    public function getCitiesBy(array $parameters)
    {
        $queryParam = array_merge($parameters, $this->getFields());
        $result = $this->request('GET', self::URL_COMMUNES, ['query' => $queryParam]);
        if ($result->getStatusCode() != 200) {
            return null;
        }

        return json_decode($result->getBody()->getContents());
    }

    /**
     * @return mixed| ResponseInterface
     */
    public function getCitiesByName(string $name)
    {
        return $this->getCitiesBy([self::PARAMETER_NAME => $name]);
    }

    /**
     * @return mixed|null
     */
    public function getCitiesByCodePostal(string $postCode)
    {
        return $this->getCitiesBy([self::PARAMETER_POSTCODE => $postCode]);
    }

    /**
     * @return mixed|null
     */
    public function getCitiesByDepartmentCode(string $departmentCode)
    {
        return $this->getCitiesBy([self::PARAMETER_DEPARTMENT_CODE => $departmentCode]);
    }

    /**
     * @return mixed|null
     */
    public function getCitiesInformationsByDepartmentCode(string $departmentCode)
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
