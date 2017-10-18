<?php
namespace Dashboard\Components;

use Dashboard\Entities\Trade;

class BalanceCalculator {
    protected $trades = [];
    protected $balances = [];
    protected $finalBalance = 0;

    protected $currentPrice = 0;


    public function addTrade(Trade $t) {
        $this->trades[$t->getId()] = $t;
    }

    protected function calculateBalance() {

        /* @var $trade Trade */
        foreach ($this->trades as $id => $trade) {
            $tradeDifference = $trade->getAmount() * $this->currentPrice - $trade->getAmount() * $trade->getPrice();
            $this->balances[$trade->getId()] = $tradeDifference;
            $this->finalBalance += $tradeDifference;
        }
    }

    public function setCurrentPrice($price)
    {
        $this->currentPrice = $price;
        $this->calculateBalance();
    }

    /**
     * @return int
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * @return int
     */
    public function getFinalBalance()
    {
        return $this->finalBalance;
    }

    /**
     * @return array
     */
    public function getBalances()
    {
        return $this->balances;
    }



}