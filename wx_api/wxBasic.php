<?php

namespace weixin;

class wxBasic
{

    static private $appid = 'wx8487b47606880e1c';
    static private $secret = '231223f3f01a75d7f021608ceec3be03';
    static private $self_token = 'zhangmengfei';

    static public function getAppid()
    {
        return self::$appid;
    }

    static public function getSecret()
    {
        return self::$secret;
    }

    static public function getSelfToken()
    {
        return self::$self_token;
    }

    static public function getConfig()
    {
        return [
            'appid'=>self::$appid,
            'secret'=>self::$secret,
            'self_token'=>self::$self_token
        ];
    }

}
