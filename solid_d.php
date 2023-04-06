<?php

interface IXMLHttpService{
    public function request(string $url, string $method, array $options = []): void;
}

class XMLHttpService implements IXMLHttpService{
    public function request(string $url, string $method, array $options = []): void {
        //
    }
}

class Http {
    private $service;

    public function __construct(IXMLHttpService $service) {
        $this->service = $service;
    }

    public function get(string $url, array $options) {
        $this->service->request($url, 'GET', $options);
    }

    public function post(string $url) {
        $this->service->request($url, 'GET');
    }
}