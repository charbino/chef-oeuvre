<?php
declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CommuneClient
 * @package App\Client
 */
class CityClient extends Client
{
    public const URL = "https://geo.api.gouv.fr/";

    public const URL_COMMUNES = "communes";
    public const URL_DEPARMENTS = "departements";

    public const PARAMETER_NAME = 'nom';
    public const PARAMETER_POSTCODE = 'codePostal';
    public const PARAMETER_CODE = 'code';
    public const PARAMETER_DEPARTMENT_CODE = 'codeDepartement';
    public const PARAMETER_FORMAT = 'format';
    public const PARAMETER_GEOMETRY = 'geometry';

    public const VALUE_GEOJSON = 'geojson';
    public const PARAMETER_CONTOUR = 'contour';


    /**
     * @param array $config
     */
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
     * @param string $parameter
     * @param string $value
     * @return mixed|null
     * @throws GuzzleException
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
     * @param String $name
     * @return mixed| ResponseInterface
     * @throws GuzzleException
     */
    public function getDepartmentByName(string $name)
    {
        return $this->getDeparmentsBy(self::PARAMETER_NAME, $name);
    }

    /**
     * @param String $code
     * @return mixed| ResponseInterface
     * @throws GuzzleException
     */
    public function getDepartmentByCode(string $code)
    {
        return $this->getDeparmentsBy(self::PARAMETER_CODE, $code);
    }


    /**
     * @param string $parameter
     * @param string $value
     * @return mixed|null
     * @throws GuzzleException
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
     * @param String $name
     * @return mixed| ResponseInterface
     * @throws GuzzleException
     */
    public function getCitiesByName(string $name)
    {
        return $this->getCitiesBy([self::PARAMETER_NAME => $name]);
    }

    /**
     * @param string $postCode
     * @return mixed|null
     * @throws GuzzleException
     */
    public function getCitiesByCodePostal(string $postCode)
    {
        return $this->getCitiesBy([self::PARAMETER_POSTCODE => $postCode]);
    }

    /**
     * @param string $departmentCode
     * @return mixed|null
     * @throws GuzzleException
     */
    public function getCitiesByDepartmentCode(string $departmentCode)
    {
        return $this->getCitiesBy([self::PARAMETER_DEPARTMENT_CODE => $departmentCode]);
    }

    /**
     * @param string $departmentCode
     * @return mixed|null
     * @throws GuzzleException
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
