<?php
interface ISecretKeyStorage{
    public function getKey(): string;
}

class KeyInFileStorage implements ISecretKeyStorage{
    public function getKey(): string
    {
        return '';
    }
}

class KeyInDBStorage implements ISecretKeyStorage{
    public function getKey(): string
    {
        return '';
    }
}

class KeyInRedisStorage implements ISecretKeyStorage{
    public function getKey(): string
    {
        return '';
    }
}

class KeyInCloudStorage implements ISecretKeyStorage{
    public function getKey(): string
    {
        return '';
    }
}

class Concept {
    private $client;
    private $secretKey;

    public function __construct(ISecretKeyStorage $secretKey) {
        $this->client = new \GuzzleHttp\Client();
        $this->secretKey = $secretKey;
    }

    public function getUserData() {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->secretKey->getKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }
}

$fileStorage = new KeyInFileStorage();
$dbStorage = new KeyInDBStorage();
$redisStorage = new KeyInRedisStorage();
$cloudStorage = new KeyInCloudStorage();

$conceptWithFileKey = new Concept($fileStorage);
$conceptWithDBKey = new Concept($dbStorage);
$conceptWithMemoryKey = new Concept($redisStorage);
$conceptWithCloudKey = new Concept($cloudStorage);

$conceptWithFileKey->getUserData();
$conceptWithDBKey->getUserData();
$conceptWithMemoryKey->getUserData();
$conceptWithCloudKey->getUserData();