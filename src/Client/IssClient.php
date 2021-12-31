<?php
declare(strict_types=1);

namespace App\Client;

use DateTime;
use GuzzleHttp\Client;

/**
 * Class IssClient
 * @package App\Client
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class IssClient extends Client
{
    const URL = 'https://api.wheretheiss.at/v1/';
    const URL_SATELLITE = 'satellites';
    const URL_COORD = 'coordinates';

    const LAT_FR_MIN = 41.340375;
    const LAT_FR_MAX = 51.100000;
    const LONG_FR_MIN = -5.10571;
    const LONG_FR_MAX = 8.242677;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        return parent::__construct(array_merge($config, ['base_uri' => self::URL]));
    }

    /**
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCurrentPosition(): array
    {
        $idSattelite = $this->getSatelliteId();
        $dataSattelite = $this->getDataSatellite($idSattelite);

        $dateNow = new DateTime();
        return [
            'latitude' => $dataSattelite->latitude,
            'longitude' => $dataSattelite->longitude,
            'speed' => $dataSattelite->velocity,
            'units' => $dataSattelite->units,
            'dateTime' => date('d-m-Y H:i', $dataSattelite->timestamp),
            'visibility' => $dataSattelite->visibility,
            'altitude' => $dataSattelite->altitude,
            'now' => $dateNow->format('d-m-Y H:i')
        ];
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSatelliteId()
    {
        $options = [
            'header' =>
                [
                    'Accept' => 'application/json',
                    'Access-Control-Allow-Origin' => '*'
                ],
        ];

        $reponse = $this->request('GET', self::URL_SATELLITE, $options);
        $responseArray = json_decode((string)$reponse->getBody());

        return $responseArray[0]->id;
    }

    /**
     * @param $idSattelite
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDataSatellite($idSattelite)
    {
        $url = self::URL_SATELLITE . "/" . $idSattelite;
        $options = [
            'header' =>
                [
                    'Accept' => 'application/json'
                ],
        ];

        $reponse = $this->request('GET', $url, $options);

        return json_decode((string)$reponse->getBody());
    }


}
