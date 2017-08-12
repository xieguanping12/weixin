<?php

/**
 * Created by PhpStorm.
 * User: xieguanping
 * Date: 2017/8/12
 * Time: 17:16
 */

define('WX_APP_TOKEN', 'lfjqofffsw');

$WxValidate = new WXValidate();
$WxValidate->tokenValidate();


class WXValidate
{
    public function tokenValidate()
    {
        $echostr = $_GET['echostr'];

        try {
            if (self::checkSign()) {
                echo $echostr;
                exit();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    private static function checkSign()
    {
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        if (!defined('WX_APP_TOKEN')) {
            throw new Exception('Not defined WX_APP_TOKEN');
        }
        $token = WX_APP_TOKEN;

        $tmpArr = [$token,$timestamp,$nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode('', $tmpArr);
        $tmpStr = sha1($tmpStr);


        if ($tmpStr === $signature) {
            return true;
        } else {
            return false;
        }
    }
}
