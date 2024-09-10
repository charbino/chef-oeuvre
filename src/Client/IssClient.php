<?php

declare(strict_types=1);

namespace App\Client;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IssClient
{
    public const URL = 'https://api.wheretheiss.at/v1/';
    public const URL_SATELLITE = 'satellites';
    public const URL_COORD = 'coordinates';
    public const LAT_FR_MIN = 41.340375;
    public const LAT_FR_MAX = 51.100000;
    public const LONG_FR_MIN = -5.10571;
    public const LONG_FR_MAX = 8.242677;

    public function __construct(
        private HttpClientInterface $client,
    )
    {
        $this->client = $this->client->withOptions([
            'base_uri' => self::URL,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getCurrentPosition(): array
    {
        $idSatelite = $this->getSatelliteId();
        $sateliteData = $this->getDataSatellite($idSatelite);

        $dateNow = new DateTime();
        return [
            'latitude' => $sateliteData['latitude'],
            'longitude' => $sateliteData['longitude'],
            'speed' => $sateliteData['velocity'],
            'units' => $sateliteData['units'],
            'dateTime' => date('d-m-Y H:i', $sateliteData['timestamp']),
            'visibility' => $sateliteData['visibility'],
            'altitude' => $sateliteData['altitude'],
            'now' => $dateNow->format('d-m-Y H:i'),
        ];
    }

    public function getSatelliteId(): ?int
    {
        $response = $this->client->request('GET', self::URL_SATELLITE, [
            'headers' =>
                [
                    'Accept' => 'application/json',
                    'Access-Control-Allow-Origin' => '*',
                ],
        ]);

        return $response->toArray()[0]['id'] ?? null;
    }

    /**
     * @param int $idSattelite
     * @return array<mixed>
     */
    public function getDataSatellite(int $idSattelite): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_SATELLITE . '/' . $idSattelite,
            [
                'headers' =>
                    [
                        'Accept' => 'application/json',
                    ],
            ]);

        return $response->toArray();
    }
}
