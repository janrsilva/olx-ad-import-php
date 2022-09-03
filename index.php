<?php
// create a pre log function

function pre()
{
    echo '<br/>';
    echo '<pre>';
    foreach (func_get_args() as $arg) {
        print_r($arg);
    }
    echo '</pre>';
}

// load vendor  autoload
require_once __DIR__ . '/vendor/autoload.php';

pre('start');

use Janrsilva\OlxAdImport\Ad;
use Janrsilva\OlxAdImport\AdCollection;
use Janrsilva\OlxAdImport\OlxApi;

$access_token = 'token';

$olxApi = new OlxApi($access_token);
pre('olxApi');
//pre($olxApi->getPublishedAds());
pre('getPublishedAds');

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

// pre($olxApi->getBasicInfo());
pre($olxApi->getCubiccmsInfo());
pre($publishedAd = $olxApi->publishAd(new AdCollection($ad)));
