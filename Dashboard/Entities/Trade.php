<?php

namespace Dashboard\Entities;

class Trade {

    const SIDE_BUY = "buy";
    const SIDE_SELL = "sell";

    public $id;
    public $fund_id;
    public $orderId;
    public $side;
    public $amount;
    public $price;
    public $date;

    /**
     * Trade constructor.
     * @param $id
     */
    public function __construct($tradeArray)
    {

        $this->setId($tradeArray['id']);
        $this->setFundId($tradeArray['fund_id']);

        $this->setAmount($tradeArray['amount']);
        $this->setPrice($tradeArray['price']);
        $this->setSide($tradeArray['side']);
        $this->setOrderId($tradeArray['order_id']);

        //[date] => 2017-10-18T06:53:05.601Z

    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getFundId()
    {
        return $this->fund_id;
    }

    /**
     * @param mixed $fund_id
     */
    public function setFundId($fund_id)
    {
        $this->fund_id = $fund_id;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return mixed
     */
    public function getSide()
    {
        return $this->side;
    }

    /**
     * @param mixed $side
     */
    public function setSide($side)
    {
        $this->side = $side;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

}