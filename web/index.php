<?php

require_once __DIR__.'/../vendor/autoload.php';

use TRTApi\TRTApi;
use Dashboard\Components\BalanceCalculator;
use Dashboard\Entities\Trade;


$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
$app['debug'] = true;


$app->get('/balance/{apiKey}/{apiSecret}', function($apiKey, $apiSecret) use($app) {

    $trtApi = new TRTApi($apiKey, $apiSecret);

    $trades = $trtApi->getTrades();
    $bc = new BalanceCalculator();

    foreach ($trades['trades'] as $t) {
        $tmpTrade = new Trade($t);
        $bc->addTrade($tmpTrade);
    }

    $ticker = $trtApi->getTicker();
    $bc->setCurrentPrice($ticker['last']);

    $result = array(
        'last' => $ticker['last'],
        'balances' => $bc->getBalances(),
        'finalBalance' => $bc->getFinalBalance()
    );

    return $app->json($result);

});

$app->run();