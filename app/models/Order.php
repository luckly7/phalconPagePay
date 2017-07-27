<?php
namespace Develop\Models;

use Phalcon\Mvc\Model;

class Order extends Model{
    /**
     * @var integer
     */
    private $id;
    /**
     * @var string
     */
    private $out_trade_no;
    /**
     * @var string
     */
    private $trade_no;
    /**
     * @var float
     */
    private $total_amount;
    /**
     * @var string
     */
    private $subject;
    /**
     * @var string
     */
    private $body;
    /**
     * @var integer
     */
    private $status;
    /**
     * @var string
     */
    private $buyer_id;
    /**
     * @var string
     */
    private $seller_id;
    /**
     * @var float
     */
    private $receipt_amount;
    /**
     * @var float
     */
    private $refund_fee;
    /**
     * @var string
     */
    private $refund_reason;
    /**
     * @var string
     */
    private $out_request_no;
    /**
     * @var integer
     */
    private $gmt_create;
    /**
     * @var integer
     */
    private $gmt_payment;
    /**
     * @var integer
     */
    private $gmt_refund;
    /**
     * @var integer
     */
    private $gmt_close;
    /**
     * @var string
     */
    private $fund_bill_list;

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource(){
        return 'Order';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param null $parameters
     * @return Order[]
     */
    public static function find($parameters = null){
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param null $parameters
     * @return Order
     */
    public static function findFirst($parameters = null){
        return parent::findFirst($parameters);
    }

    /**
     * @return string
     */
    public function getOutTradeNo()
    {
        return $this->out_trade_no;
    }

    /**
     * @param string $out_trade_no
     */
    public function setOutTradeNo($out_trade_no)
    {
        $this->out_trade_no = $out_trade_no;
    }

    /**
     * @return string
     */
    public function getTradeNo()
    {
        return $this->trade_no;
    }

    /**
     * @param string $trade_no
     */
    public function setTradeNo($trade_no)
    {
        $this->trade_no = $trade_no;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * @param float $total_amount
     */
    public function setTotalAmount($total_amount)
    {
        $this->total_amount = $total_amount;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getBuyerId()
    {
        return $this->buyer_id;
    }

    /**
     * @param string $buyer_id
     */
    public function setBuyerId($buyer_id)
    {
        $this->buyer_id = $buyer_id;
    }

    /**
     * @return string
     */
    public function getSellerId()
    {
        return $this->seller_id;
    }

    /**
     * @param string $seller_id
     */
    public function setSellerId($seller_id)
    {
        $this->seller_id = $seller_id;
    }

    /**
     * @return float
     */
    public function getReceiptAmount()
    {
        return $this->receipt_amount;
    }

    /**
     * @param float $receipt_amount
     */
    public function setReceiptAmount($receipt_amount)
    {
        $this->receipt_amount = $receipt_amount;
    }

    /**
     * @return float
     */
    public function getRefundFee()
    {
        return $this->refund_fee;
    }

    /**
     * @param float $refund_fee
     */
    public function setRefundFee($refund_fee)
    {
        $this->refund_fee = $refund_fee;
    }

    /**
     * @return string
     */
    public function getRefundReason()
    {
        return $this->refund_reason;
    }

    /**
     * @param string $refund_reason
     */
    public function setRefundReason($refund_reason)
    {
        $this->refund_reason = $refund_reason;
    }


    /**
     * @return string
     */
    public function getOutRequestNo()
    {
        return $this->out_request_no;
    }

    /**
     * @param string $out_request_no
     */
    public function setOutRequestNo($out_request_no)
    {
        $this->out_request_no = $out_request_no;
    }


    /**
     * @return int
     */
    public function getGmtCreate()
    {
        return $this->gmt_create;
    }

    /**
     * @param int $gmt_create
     */
    public function setGmtCreate($gmt_create)
    {
        $this->gmt_create = $gmt_create;
    }

    /**
     * @return int
     */
    public function getGmtPayment()
    {
        return $this->gmt_payment;
    }

    /**
     * @param int $gmt_payment
     */
    public function setGmtPayment($gmt_payment)
    {
        $this->gmt_payment = $gmt_payment;
    }

    /**
     * @return int
     */
    public function getGmtRefund()
    {
        return $this->gmt_refund;
    }

    /**
     * @param int $gmt_refund
     */
    public function setGmtRefund($gmt_refund)
    {
        $this->gmt_refund = $gmt_refund;
    }

    /**
     * @return int
     */
    public function getGmtClose()
    {
        return $this->gmt_close;
    }

    /**
     * @param int $gmt_close
     */
    public function setGmtClose($gmt_close)
    {
        $this->gmt_close = $gmt_close;
    }

    /**
     * @return string
     */
    public function getFundBillList()
    {
        return $this->fund_bill_list;
    }

    /**
     * @param string $fund_bill_list
     */
    public function setFundBillList($fund_bill_list)
    {
        $this->fund_bill_list = $fund_bill_list;
    }


}