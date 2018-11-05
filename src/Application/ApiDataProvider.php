<?php

namespace BlueClient\Application;

use BlueClient\Application\Exception\ItemNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;

/**
 * Class ApiDataProvider
 * @package BlueClient\Application
 */
class ApiDataProvider
{
    private const ITEMS_RESOURCE_URL = 'items';

    private const DIRECTORY_SEPARATOR = '/';

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
        try {
            $response = $this->client->delete(self::ITEMS_RESOURCE_URL . self::DIRECTORY_SEPARATOR . $id);
        } catch (ClientException $exception) {
            if ($exception->getCode() == 404) {
                throw new ItemNotFoundException();
            }
        }

        return json_decode($response->getBody(), true);
    }
}