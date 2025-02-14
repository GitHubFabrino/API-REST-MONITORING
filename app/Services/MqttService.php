<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MqttService
{
    protected $client;

    public function __construct()
    {
        $server   = 'localhost'; // Adresse du broker MQTT (utilisez 'localhost' si le broker est sur la même machine)
        $port     = 1883; // Port du broker MQTT
        $clientId = 'laravel_mqtt_client'; // ID du client
        $this->client = new MqttClient($server, $port, $clientId);

        // Connexion au broker
        $this->client->connect();
    }
    
    public function publish($topic, $message)
    {
        try {
            $this->client->publish($topic, $message, 0);
        } catch (MqttClientException $e) {
            // Gérer l'exception
            return false;
        }
        return true;
    }

    public function subscribe($topic, callable $callback)
    {
        try {
            $this->client->subscribe($topic, function ($topic, $message) use ($callback) {
                $callback($topic, $message);
            }, 0);

            $this->client->loop(true);
        } catch (MqttClientException $e) {
            // Gérer l'exception
            return false;
        }
        return true;
    }

    public function __destruct()
    {
        $this->client->disconnect();
    }
}
