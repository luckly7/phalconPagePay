<?php

defined('ROOT_PATH') || define('ROOT_PATH', realpath('..'));

$database = [
    'debug'         => true,
    'adapter' => 'Mysql',
    'host' => '120.55.184.175',
    'username' => 'root',
    'password' => 'root',
    'dbname' => 'amai',
    'charset' => 'utf8'
];

$alipay = [
    //应用ID,您的APPID。
    'app_id' => "2016080500169037",

    //商户私钥
    'merchant_private_key' => "MIIEpQIBAAKCAQEA28ZaAPmpg/wzWepW2bftZFG9a3V47FGgT4pAeuS7vdAR9qBkpMbSl1Rn1sfoxoH4kUocNrUGyyYMNhrm6xDWRkL8GX1zVN7YoADQh3zyQNL/i4ibEJz4hl99WLtKT0TTq8/boHLrWGtnv3sPweKIy+6aMym8pEosOCZ1kd0/QedA2hInLrM7wJHIXBRZvDWkf5KSPYu4qiQ8tR3HtPd/BlVtXPvK8vrhn1A0y93Yz8mC+sUhsHIQansIjZ7ohmfFkA+s/0Zjd4kndBiDyRsx+ScD4rvDJGwXN3Uz9K3fDdVIfs/+qOYGx75xhSNRYimpIvPXvfahfJQrbqFIA4VqnQIDAQABAoIBAETJMCJeAdBtfyUFU2mRR5u+earIebB9W8+JVeUg8iHWncizKszn7cGviVCQASsgQsw2hd4ZiqbKocfNY7ju7CHRlVXlDdPia6qolpvRX4EqiREDEIWCm8Zy3KiI9hkZUabUx8jQLxjdhPtJaQUmAerSIzEgPwqsrGpmnyWoOcRGKGqoxpXU4L3RgYgFof3cT2Nc6donVHfUGz7ctMaLVIBLbeFG4qJDWwYlnz/CwITDedynrxssrJpV4Vh+MXItu21IrQ3UE8Y0DEW9lyTsvdGJZy/hjBk/XzDMnEutdy7/W8IfyY24wXcGk59exywkojpLuO5YZ+nAcn1HjHzL2AECgYEA7pOWvy+5vfTMbOsOq6bJr5TuyuMG8bYrsL7SiHekZNIXbxvw4L9knvU9lH1lUu2MEBEOHWBCw4d2gm3oJnjC/CZY0k/GLsTJom92r+LnVH+P3BTp7buWRnIjljBvkI6G5M7HO3U5HK8hlbM1U9LF2Ax+leUHY7hoMiIRGU/gHk0CgYEA69M/SNyvUzqR2IbmARw7d4Q++JacKGlHyNRyikgbQGYqPzGbcK1SZn1Vp22Y3nOQIwk/DqlMW5OCx9duvw2naZ/6a2DPQyWruDc6094qpS83ZWRGgGhK7VLzMzq8eUZQQIYnxKF5mtKfHz2IEWSCY6wMx7ZfMCkcC7LgvAbPxZECgYEAuvevC+W7CsLt8e3EcYEkThXJjfadWpAJbVoeZBRfISQEeW7MN1XG5UwMFnKvFW5UdcLn7N2jdNiUZ2L6rCu3oyPqN+eMyNovqrzvpqeL4wyVEUTSjxyTiGGqwejzhbYswOPL/yy+tVwKVec7w5VKtyYTjiUOxXefMKrB+7Q9T4ECgYEAzKyb0HE4+dNrobHzDiOiuShePwL4pVo6o2M/xiSvAkWphQ9ZCYJkce9118qXUvqZrs7nm6H0U8bDSw7/X3JKSrI+ddOgD3cygr/sntXDzXodajKNvgTGgxPrYBsqWVddb6MAAPjkwirrUAHnhrDlOfypWuw90V7cqIqn4olG6wECgYEA2TH1AIWNi0xaieif/zJOE3QXgDmpUpoHzq/OYQfRz2wSI6Lhy9hf2iVITRmy6SzSSGWZC5V+j5shIB0UdZGs6ikHOHQe97ce61+Kp4Ii9outI2ho3I/f4du9qgDSZvkgyLdFCLKYYPZULD61dpYA7MGO3ALWYpNgungE4YiZDSo=",

    //异步通知地址
    'notify_url' => "http://wxdevelop.amailive.com/Pagepay/notify_url",

    //同步跳转
    'return_url' => "http://wxdevelop.amailive.com/Pagepay/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA0kp7V8QzE9GPjTOyoJ4lqG19gcJfP+DOeMfpFLjMaysb/geOBNoufTV9LKnnL0bLk5Lrg5Y+y/zGmbQjrCVTiWFfzBPEGSI89LZbOlV86CUWtXdWYl3fwvFACic4s5ssvkNCcKKAlVAD5BNor2CW3UxYtrll0eBohbyKVZMTuHKXV3IQ3jrmPXbg5q51fhUs16fN065FdhVfvnOsySUpTV1V3BmByAWkUh3QS2xOC88vx2h8c/L+5ZYHtpgHYn9c81HeI/PgEybpTmEb0+FjJvrvuab/xXoRaDQzcPQ6KK+Ay4FxLpGdOnKmZ+cA3BHu/anlcLO8ZGmFpM7VP+x4TQIDAQAB",

    'seller_id' => '2088102169985265',
];
$logger = [
    'dir'           => ROOT_PATH . '/logs/',
];
return [
    'database'  => $database,
    'alipay'    => $alipay,
    'logger'    => $logger,
];