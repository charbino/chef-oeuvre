<?php
declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CadastreClient
 * @package App\Client
 *
 * @author Sébastien Framinet <sebastien.framinet@asdoria.com>
 */
class CadastreClient extends Client
{
    const URL = "https://apicarto.ign.fr/api/cadastre/";
    const URL_COMMUNE = "commune";
    const URL_DIVISION = "division";
    const URL_PARCELLE = "parcelle";
    const CODE_INSEE = "code_insee";

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $config['base_uri'] = self::URL;

        parent::__construct($config);
    }

    /**
     * @param string $codeInsee
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @param string $codeInsee
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     * @param string $codeInsee
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
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
