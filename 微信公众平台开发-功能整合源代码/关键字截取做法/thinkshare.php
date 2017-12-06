<?php
/**
 * 乐思乐享微信公众平台开发
 * ================================
 * Copyright 2013-2014 David Tang
 * 乐思乐享博客园
 * http://www.cnblogs.com/mchina/
 * 乐思乐享微信论坛
 * http://www.joythink.net/
 * ================================
 * Author:David|唐超
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2014-02-08
 */

//引入函数文件
require_once('includes/weather/weather.func.inc.php');
require_once('includes/translate.func.inc.php');

//define your token
define("TOKEN", "thinkshare");
$wechatObj = new wechat();
$wechatObj->responseMsg();

class wechat
{
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {
              		$msgType = "text";

					//截取关键字
					$weather_key = mb_substr($keyword,-2,2,"UTF-8");
					$city_key = mb_substr($keyword,0,-2,"UTF-8");
					$translate_key = mb_substr($keyword,0,2,"UTF-8");
					$word_key = mb_substr($keyword,2,200,"UTF-8");

					if($weather_key == '天气' && !empty($city_key) && $translate_key != '翻译'){
						$contentStr = _weather($city_key);
					}elseif($translate_key == '翻译' && !empty($word_key)){
						$contentStr = _baiduDic($word_key);
					}else{
						$contentStr = "感谢您关注【卓锦苏州】\n微信号：zhuojinsz";
					}

                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }
}

?>