<?php

// load vendor  autoload
require_once __DIR__ . '/vendor/autoload.php';

use Janrsilva\OlxAdImport\Ad;
use Janrsilva\OlxAdImport\AdCollection;
use Janrsilva\OlxAdImport\OlxApi;

$access_token = 'token';

$olxApi = new OlxApi($access_token);

$ad = new Ad();
$ad->id = '123456789';
$ad->type = Ad::TYPE_RENT;
$ad->operation = Ad::OPERATION_INSERT;
$ad->category = 2060; // 2060 = motos, 2020 = carros, 2040 = caminhões
$ad->subject = 'Teste de anúncio';
$ad->body = 'Teste de anúncio';
$ad->phone = 31975064099;
$ad->zipcode = '30620080';
$ad->price = 1000;
$ad->currency = 'BRL';
$ad->location = 'São Paulo';
$ad->images = [
    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png',
    'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png'
];

// Campos especificos de veiculos 
$ad->params = [
    'regdate' => '2018',
    'mileage' => '10000',
    'cubiccms' => '23', //160
];

$olxApi->getCubiccmsInfo();

try {
    $publishedAd = $olxApi->publishAd(new AdCollection($ad));
} catch (\Exception $ex) {
    print_r($ex->getMessage());
} catch (\Throwable $th) {
    print_r($th->getMessage());
}