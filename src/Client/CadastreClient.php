<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;

class CadastreClient extends Client
{
    public const URL = 'https://apicarto.ign.fr/api/cadastre/';
    public const URL_COMMUNE = 'commune';
    public const URL_DIVISION = 'division';
    public const URL_PARCELLE = 'parcelle';
    public const CODE_INSEE = 'code_insee';

    public function __construct(array $config = [])
    {
        $config['base_uri'] = self::URL;

        parent::__construct($config);
    }

    /**
     * @return mixed|null
     */
    public function getCity(string $codeInsee)
    {
        $url = self::URL . self::URL_COMMUNE;
        $result = $this->request('GET', $url, ['query' => [self::CODE_INSEE => $codeInsee]]);
        if ($result->getStatusCode() != 200) {
            return null;
        }

        return json_decode($result->getBody()->getContents());
    }

    /**
     * @return mixed|null
     */
    public function getPlots(object $city)
    {
        $url = self::URL . self::URL_DIVISION;
        $result = $this->request('GET', $url, ['query' => [self::CODE_INSEE => $city->properties->code_insee]]);
        if ($result->getStatusCode() != 200) {
            return null;
        }

        return json_decode($result->getBody()->getContents());
    }

    /**
     * @return mixed|null
     */
    public function getParcelles(object $city)
    {
        $url = self::URL . self::URL_PARCELLE;
        $result = $this->request('GET', $url, ['query' => [self::CODE_INSEE => $city->properties->code_insee]]);
        if ($result->getStatusCode() != 200) {
            return null;
        }

        return json_decode($result->getBody()->getContents());
    }
}
