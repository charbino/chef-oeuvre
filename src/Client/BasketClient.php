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

namespace App\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BasketClient
{
    public const URL = 'https://api.balldontlie.io/v1/';
    public const API_KEY = 'b6ca3a72-e392-4ef5-8b07-7bcc79da49ef'; //TODO PUT API KEY IN .ENV PLEASE

    public function __construct(
        private HttpClientInterface $client
    ) {
    }

    /**
     * @param string $search
     * @param int $page
     * @param int $perPage
     * @return array<mixed>
     */
    public function getPlayers(string $search, int $page = 0, int $perPage = 25): array
    {
        $response = $this->client->request(
            'GET',
            self::URL . 'players',
            [
                'query' => [
                    'search' => $search,
                    'page' => $page,
                    'per_page' => $perPage,
                ],
                'headers' => [
                    'Authorization' => self::API_KEY,
                ],
            ]
        );


        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return $response->toArray()['data'];
    }

    /**
     * @param int $id
     * @return array<mixed>
     */
    public function getStatPlayer(int $id): array
    {
        $response = $this->client->request(
            'GET',
            self::URL . 'stats',
            [
                'query' => [
                    'player_ids' => [$id]
                ],
                'headers' => [
                    'Authorization' => self::API_KEY,
                ],
            ]
        );

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return $response->toArray();
    }

    /**
     * @param array<int> $ids
     * @param array<string,string> $filters
     * @return array<mixed>
     */
    public function getStatPlayers(array $ids, array $filters = []): array
    {
        //use this function for not have index in query string parameter
        //see : https://stackoverflow.com/questions/60440737/symfony-httpclient-get-request-with-multiple-query-string-parameters-with-same-n
        $url = self::URL . 'stats?' . $this->createQueryString(array_merge(array_values($ids), $filters));

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => self::API_KEY,
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return [];
        }

        return $response->toArray();
    }

    /**
     * @param array<string> $queryArray
     * @return string|null
     */
    private function createQueryString(array $queryArray = []): ?string
    {
        $queryString = http_build_query($queryArray, '', '&', \PHP_QUERY_RFC3986);
        $queryString = preg_replace('/%5B(?:\d|[1-9]\d+)%5D=/', '%5B%5D=', $queryString); //foo[]=x&foo[]=y

        return $queryString !== '' ? $queryString : null;
    }
}
