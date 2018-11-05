<?php

namespace BlueClient\Application;

use GuzzleHttp\Client;

/**
 * Class ApiDataProvider
 * @package BlueClient\Application
 */
class ApiDataProvider
{
    private const ITEMS_RESOURCE_URL = 'items';

    /**
     * @var Client
     */
    private $client;

    /**
     * ApiDataProvider constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function findAllItems(): array
    {
        return json_decode($this->client->get(self::ITEMS_RESOURCE_URL)->getBody(), true);
    }

    /**
     * @param int $id
     * @return array
     */
    public function findItemById(int $id): array
    {
        return json_decode($this->client->get(self::ITEMS_RESOURCE_URL . '/' . $id)->getBody(), true);
    }

    /**
     * @param int $id
     * @return array
     */
    public function remove(int $id): array
    {
        return json_decode($this->client->delete(self::ITEMS_RESOURCE_URL . '/' . $id)->getBody(), true);
    }
}