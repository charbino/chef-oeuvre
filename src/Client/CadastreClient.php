<?php

declare(strict_types=1);

namespace App\Client;

use App\Model\City\City;
use App\Transformer\City\CitiesTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CadastreClient
{
    public const URL = 'https://apicarto.ign.fr/api/cadastre/';
    public const URL_COMMUNE = 'commune';
    public const URL_DIVISION = 'division';
    public const URL_PARCELLE = 'parcelle';
    public const CODE_INSEE = 'code_insee';

    public function __construct(
        private HttpClientInterface $client,
        private CitiesTransformer $citiesTransformer
    ) {
    }

    public function getCity(string $codeInsee): ?City
    {
        $url = self::URL . self::URL_COMMUNE;
        $response = $this->client->request('GET', $url, ['query' => [self::CODE_INSEE => $codeInsee]]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        $cities = $this->citiesTransformer->transform($response->toArray()['features'] ?? []);

        return $cities[0] ?? null;
    }

    public function getPlots(City $city): ?array
    {
        $url = self::URL . self::URL_DIVISION;
        $response = $this->client->request('GET', $url, ['query' => [self::CODE_INSEE => $city->getCodeInsee()]]);

        return $response->getStatusCode() === 200 ? $response->toArray() : null;
    }

    public function getParcelles(City $city): ?array
    {
        $url = self::URL . self::URL_PARCELLE;
        $response = $this->client->request('GET', $url, ['query' => [self::CODE_INSEE => $city->getCodeInsee()]]);

        return $response->getStatusCode() === 200 ? $response->toArray() : null;
    }
}
