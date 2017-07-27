<?php
//namespace Develop\Controllers;

use Phalcon\Mvc\Controller;
use Develop\Alipay;
use Phalcon\Mvc\View;
use Develop\Models;
use Develop\Models\Order;

header("Content-type: text/html; charset=utf-8");

class PagepayController extends Controller
{
    public function pagePayAction()
    {
        $out_trade_no = $this->getOutTradeNo();
        $total_amount = trim($this->request->getPost('total_amount'));
        $subject = trim($this->request->getPost('subject'));
        $body = trim($this->request->getPost('body'));
        $time_express = trim($this->request->getPost('time_express'));

        $payRequestBuilder = new Alipay\AlipayTradePagePayContentBuilder();
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setTimeExpress($time_express);

        $order = new Order();
        $order->setOutTradeNo($out_trade_no);
        $order->setTotalAmount($total_amount);
        $order->setSubject($subject);
        $order->setBody($body);
        $order->setStatus('WAIT_BUYER_PAY');
        $order->setSellerId($this->config->alipay->seller_id);
        $order->setGmtCreate(time());

        if ($order->create() === true) {
            $aop = new Alipay\AlipayTradeService($this->config->alipay);
            $response = $aop->pagePay($payRequestBuilder, $this->config->alipay->return_url, $this->config->alipay->notify_url);
            //打印出页面
            var_dump($response);
        } else {
            $this->response->redirect('Index\index');
        }
    }


    public function queryAction()
    {
        $out_trade_no = trim($this->request->getPost('out_trade_no'));
        $trade_no = trim($this->request->getPost('trade_no'));


        $requestBuilder = new Alipay\AlipayTradeQueryContentBuilder();
        $requestBuilder->setOutTradeNo($out_trade_no);
        $requestBuilder->setTradeNo($trade_no);

        $aop = new Alipay\AlipayTradeService($this->config->alipay);
        $response = $aop->Query($requestBuilder);

        return json_encode($response);
    }

    public function refundAction()
    {
        $out_trade_no = trim($this->request->getPost('out_trade_no'));
        $trade_no = trim($this->request->getPost('trade_no'));
        $refund_amount = floatval($this->request->getPost('refund_amount'));
        $refund_reason = trim($this->request->getPost('refund_reason'));
        $out_request_no = trim($this->request->getPost('out_request_no'));

        $requestBuilder = new Alipay\AlipayTradeRefundContentBuilder();
        $requestBuilder->setTradeNo($trade_no);
        $requestBuilder->setOutTradeNo($out_trade_no);
        $requestBuilder->setRefundAmount($refund_amount);
        $requestBuilder->setRefundReason($refund_reason);
        $requestBuilder->setOutRequestNo($out_request_no);

        $aop = new Alipay\AlipayTradeService($this->config->alipay);
        $response = $aop->Refund($requestBuilder);
        if ($response->code == 10000) {
            $response->out_request_no = $out_request_no;
            $order = new Order();
            $out_trade_no_new = $response->out_trade_no;
            $trade_no_new = $response->trade_no;
            $orderOne = $order->findFirst("out_trade_no = '$out_trade_no_new' or trade_no = '$trade_no_new'");
            $RefundFee = $response->refund_fee;
            $orderOne->setRefundFee($RefundFee);
            $orderOne->setOutRequestNo($out_request_no);
            $orderOne->setGmtRefund(time());
            if ($orderOne->update() == true) {
                return json_encode($response);
            } else {
                //40007代表支付宝退款成功，写入商户数据库失败
                $response->code = '40007';
                return json_encode($response);
            }
        } else {
            return json_encode($response);
        }
    }

    public function refundQueryAction()
    {
        $out_trade_no = trim($this->request->getPost('out_trade_no'));
        $trade_no = trim($this->request->getPost('trade_no'));
        $out_request_no = trim($this->request->getPost('out_request_no'));

        $requestBuilder = new Alipay\AlipayTradeFastpayRefundQueryContentBuilder();
        $requestBuilder->setOutTradeNo($out_trade_no);
        $requestBuilder->setTradeNo($trade_no);
        $requestBuilder->setOutRequestNo($out_request_no);

        $aop = new Alipay\AlipayTradeService($this->config->alipay);
        $response = $aop->refundQuery($requestBuilder);
        return json_encode($response);
    }

    public function closeAction()
    {
        $out_trade_no = trim($this->request->getPost('out_trade_no'));
        $trade_no = trim($this->request->getPost('trade_no'));

        $requestBuilder = new Alipay\AlipayTradeCloseContentBuilder();
        $requestBuilder->setTradeNo($trade_no);
        $requestBuilder->setOutTradeNo($out_trade_no);

        $aop = new Alipay\AlipayTradeService($this->config->alipay);
        $response = $aop->Close($requestBuilder);


        if ($response->code == 10000) {
            $order = new Order();
            $out_trade_no_new = $response->out_trade_no;
            $trade_no_new = $response->trade_no;
            $orderOne = $order->findFirst("out_trade_no = '$out_trade_no_new'");
            $orderOne->setTradeNo($trade_no_new);
            $orderOne->setStatus('TRADE_CLOSED');
            $orderOne->setGmtClose(time());
            if ($orderOne->save() === true) {
                return json_encode($response);
            } else {
                //40007代表支付宝退款成功，写入商户数据库失败
                $response->code = '40007';
                return json_encode($response);
            }
        } else {
            return json_encode($response);
        }
    }

    /**
     *
     */
    public function notify_urlAction()
    {
        $arr = $this->request->getPost();
        $alipaySevice = new Alipay\AlipayTradeService($this->config->alipay);
        $alipaySevice->writeLog(var_export($arr, true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if ($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号
            $out_trade_no = $this->request->getPost('out_trade_no');

            //支付宝交易号
            $trade_no = $this->request->getPost('trade_no');

            //交易状态
            $trade_status = $this->request->getPost('trade_status');

            //交易付款时间 or 退款时的最后一次退款时间
            $gmt_payment = $this->request->getPost('gmt_payment');

            //交易关闭时间
            $gmt_close = $this->request->getPost('gmt_close');

            //买家用户号
            $buyer_id = $this->request->getPost('buyer_id');

            // 实际支付的金额
            $receipt_amount = $this->request->getPost('receipt_amount');

            //支付方式
            $fund_bill_list = $this->request->getPost('fund_bill_list');

            $order = new Order();
            $orderOne = $order->findFirst("out_trade_no = $out_trade_no");

            if ($orderOne && $orderOne->getTotalAmount() == $this->request->getPost('total_amount') &&
                $orderOne->getSellerId() == $this->request->getPost('seller_id') &&
                $this->request->getPost('app_id') == $this->config->alipay->app_id
            ) {

                if ($trade_status == 'TRADE_SUCCESS' || $trade_status == 'TRADE_FINISHED') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //付款完成后，支付宝系统发送该交易状态通知
                    if ($trade_no && !is_null($trade_no)) {
                        $orderOne->setTradeNo($trade_no);
                    }
                    if ($gmt_payment && !is_null($gmt_payment)) {
                        $orderOne->setGmtPayment(time($gmt_payment));
                    }
                    if ($gmt_close && !is_null($gmt_close)) {
                        $orderOne->setGmtPayment(time($gmt_close));
                    }
                    if ($buyer_id && !is_null($buyer_id)) {
                        $orderOne->setBuyerId($buyer_id);
                    }
                    if ($receipt_amount && !is_null($receipt_amount)) {
                        $orderOne->setReceiptAmount($receipt_amount);
                    }
                    if ($fund_bill_list && !is_null($fund_bill_list)) {
                        $orderOne->setFundBillList($fund_bill_list);
                    }
                    $orderOne->setStatus($trade_status);
                    if ($orderOne->update() == true) {
                        echo 'success';
                    } else {
                        echo 'fail';
                    }
                } else {
                    $alipaySevice->writeLog(var_export($trade_status . 'other', true));
                }
            } else {
                echo 'fail';
            }
        } else {
            //验证失败
            echo "fail";
        }
    }

    public function return_urlAction()
    {
        $arr = $this->request->get();
        $alipaySevice = new Alipay\AlipayTradeService($this->config->alipay);
        $result = $alipaySevice->check($arr);
        if ($result) {
            $this->view->setVar("result", "验证成功");
        } else {
            $this->view->setVar("result", "验证失败");
        }
    }

    public function redirect_uriAction()
    {
    }

    public function getOutTradeNo()
    {
        $date = getdate();
        return $date['year'] . $date['mon'] . $date['mday'] . $date['hours'] . $date['minutes'] . $date['seconds'] . rand(100, 10000);
    }
}