<?php
header("Content-type: text/html; charset=utf-8");

$post_data=[
//    'out_trade_no'         =>      '123809536',
    'total_amount'     =>      200,
    'subject'     =>      'fdfdfdf',
    /*'body'     =>      '5adfgdafg3',
    'time_express'     =>      '20m',*/
];

$ch = curl_init();
$url = 'http://wxdevelop.amailive.com/Pagepay/pagePay';
curl_setopt($ch , CURLOPT_URL , $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_HEADER, false);

$res = curl_exec($ch);
curl_close($ch);

//var_dump($res);