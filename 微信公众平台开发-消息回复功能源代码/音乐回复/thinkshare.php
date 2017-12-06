<?php
/**
 * 微信公众平台-音乐回复功能源代码
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-12
 */

//引入回复音乐的函数文件
require_once 'responseMusic.func.inc.php';
//引入回复文本的函数文件
require_once 'responseText.func.inc.php';

//define your token
define("TOKEN", "thinkshare");
$wechatObj = new wechat();
$wechatObj->responseMsg();
//$wechatObj->valid();

class wechat
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $keyword = trim($postObj->Content);
       
				if(!empty( $keyword ))
                {
                	$resultStr = _response_music($postObj,$keyword);
					if($resultStr <> '')
					{
						echo $resultStr;
					}else
					{
						echo _response_text($postObj,"未查询到【".$keyword."】的歌曲信息！");	
					}
                	
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
}

?>