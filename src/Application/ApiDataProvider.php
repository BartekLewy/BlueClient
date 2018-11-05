<?php

namespace BlueClient\Application;

use BlueClient\Application\Exception\CantCreateItemException;
use BlueClient\Application\Exception\CantUpdateItemException;
use BlueClient\Application\Exception\ItemNotFoundException;
use BlueClient\Application\Exception\ItemWasNotUpdatedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
     * @throws ItemNotFoundException
     */
    public function findItemById(int $id): array
    {
        try {
            $response = $this->client->get(self::ITEMS_RESOURCE_URL . self::DIRECTORY_SEPARATOR . $id);
        } catch (ClientException $exception) {
            Log::critical($exception->getMessage());
            if ($exception->getCode() == 404) {
                throw new ItemNotFoundException();
            }
        }
        return json_decode($response->getBody(), true);
    }

    /**
     * @param int $id
     * @return array
     * @throws ItemNotFoundException
     */
    public function remove(int $id): array
    {
        try {
            $response = $this->client->delete(self::ITEMS_RESOURCE_URL . self::DIRECTORY_SEPARATOR . $id);
        } catch (ClientException $exception) {
            Log::critical($exception->getMessage());
            if ($exception->getCode() == Response::HTTP_NOT_FOUND) {
                throw new ItemNotFoundException();
            }
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $name
     * @param int $amount
     * @return array
     * @throws CantCreateItemException
     */
    public function create(string $name, int $amount): array
    {
        try {
            $response = $this->client->post(self::ITEMS_RESOURCE_URL, [
                'form_params' => [
                    'name' => $name,
                    'amount' => $amount
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (ClientException $exception) {
            Log::critical($exception->getMessage());
            throw new CantCreateItemException();
        }
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $amount
     * @return array
     * @throws CantUpdateItemException
     * @throws ItemWasNotUpdatedException
     */
    public function update(int $id, string $name, int $amount): array
    {
        try {
            $response = $this->client->patch(self::ITEMS_RESOURCE_URL . self::DIRECTORY_SEPARATOR . $id, [
                'form_params' => [
                    'name' => $name,
                    'amount' => $amount
                ]
            ]);

            if ($response->getStatusCode() == Response::HTTP_NOT_MODIFIED) {
                throw new ItemWasNotUpdatedException();
            }

            return json_decode($response->getBody(), true);
        } catch (ClientException $exception) {
            Log::critical($exception->getMessage());
            throw new CantUpdateItemException();
        }
    }
}