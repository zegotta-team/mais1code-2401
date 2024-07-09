<?php

class ApiController
{
    public function cep() {
        $cep = $_GET['cep'];

        $curl = curl_init("https://brasilapi.com.br/api/cep/v1/$cep");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        header('Content-Type: application/json');
        http_response_code($httpcode);
        echo $body;
    }

    public function cnpj() {
        $cnpj = $_GET['cnpj'];

        $curl = curl_init("https://brasilapi.com.br/api/cnpj/v1/$cnpj");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($curl);

        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        header('Content-Type: application/json');
        http_response_code($httpcode);
        echo $body;
    }
}