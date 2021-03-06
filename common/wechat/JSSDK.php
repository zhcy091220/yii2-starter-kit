<?php
namespace common\wechat;

use Yii;
use common\models\KeyStorageItem;

/**
 * 获取微信使用权限签名
 */
class JSSDK {
    private $appId;
    private $appSecret;
    private $jsapi_ticket;
    private $access_token;

    public function __construct($appId, $appSecret) {
        $this->appId        = $appId;
        $this->appSecret    = $appSecret;
        $this->jsapi_ticket = 'gedu.jsapi_ticket';
        $this->access_token = 'gedu.access_token';
    }

    public function getSignPackage($url) {
        $jsapiTicket = $this->getJsApiTicket();
        if (isset($jsapiTicket->errcode) && isset($jsapiTicket->errmsg)) {
            return $jsapiTicket;
        }

        // 注意 URL 一定要动态获取，不能 hardcode.
        // $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        // $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr  = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "jsapiTicket" => $jsapiTicket,
            "appId"       => $this->appId,
            "nonceStr"    => $nonceStr,
            "timestamp"   => $timestamp,
            "url"         => $url,
            "signature"   => $signature,
            "rawString"   => $string
        );
        return $signPackage; 
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str   = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file($this->jsapi_ticket));

        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            if (isset($accessToken->errcode) && isset($accessToken->errmsg)) {
                return $accessToken;
            }
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res    = json_decode($this->httpGet($url));
            $ticket = $res->ticket;

            if ($ticket) {
                $data->expire_time  = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $this->set_php_file($this->jsapi_ticket, json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    private function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file($this->access_token));

        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
// var_dump($res);exit;
// var_dump($this->httpGet($url));exit;
            if ($res != NULL && isset($res->errcode) && isset($res->errmsg)) {
                return $res;
            }
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time  = time() + 7000;
                $data->access_token = $access_token;
                $this->set_php_file($this->access_token, json_encode($data));
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        /*
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_URL, $url);
        */

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename) {
        return trim(KeyStorageItem::findOne($filename)->value);
    }
    private function set_php_file($filename, $content) {
        $model = KeyStorageItem::findOne($filename);
        if ($model) {
            $model->value   = $content;
            $model->comment = '获取微信使用权限签名，有效时间7200s';
        }else{
            $model          = new KeyStorageItem;
            $model->key     = $filename;
            $model->value   = $content;
            $model->comment = '获取微信使用权限签名，有效时间7200s';
        }
        if (!$model->save()) {
            return $model->getErrors();
        }
        return true;
    }
}


?>

