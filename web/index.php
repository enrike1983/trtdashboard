<?php

require_once __DIR__.'/../vendor/autoload.php';

use TRTApi\TRTApi;
use Dashboard\Components\BalanceCalculator;
use Dashboard\Entities\Trade;


$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));
$app['debug'] = true;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.twig', [
    ]);
});

$app->get('/balance/{apiKey}/{apiSecret}/{fundIds}', function($apiKey, $apiSecret, $fundIds) use($app) {

    $trtApi = new TRTApi($apiKey, $apiSecret);

    $funds = explode(',', $fundIds);

    if(!count($funds)) {
       throw new \Exception('No funds selected');
    }

    foreach($funds as $fundId) {
        $trades = $trtApi->getTrades($fundId);
        $bc = new BalanceCalculator();

        if(!isset($trades['trades'])) {
           throw new \Exception('The API did not return the expected result');
        }

        foreach ($trades['trades'] as $t) {
            $tmpTrade = new Trade($t);
            $bc->addTrade($tmpTrade);
        }

        $ticker = $trtApi->getTicker($fundId);
        $bc->setCurrentPrice($ticker['last']);

        $result[$fundId] = array(
            'last' => $ticker['last'],
            'balances' => $bc->getBalances(),
            'finalBalance' => $bc->getFinalBalance()
        );
    }

    return $app->json($result);

});

$app->run();
