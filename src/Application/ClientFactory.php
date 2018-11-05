<?php

namespace BlueClient\Application;

use GuzzleHttp\Client;

/**
 * Class ClientFactory
 * @package BlueClient\Application
 */
class ClientFactory
{
    /**
     * @return Client
     */
    public static function createFromConfig(): Client
    {
        return new Client([
            'base_uri' => config('blueconfig.url'),
        ]);
    }
}