<?php
/**
 * 微信公众平台-图文回复功能源代码
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-09
 */

//引入回复图文的函数文件
require_once 'responseNews.func.inc.php';

//define your token
define("TOKEN", "thinkshare");
$wechatObj = new wechatCallbackapi();
$wechatObj->responseMsg();
//$wechatObj->valid();

class wechatCallbackapi
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
					$record=array(
						'title' =>'山塘街',
						'description' =>'山塘街东起阊门渡僧桥，西至苏州名胜虎丘山的望山桥，长约七里，所以苏州俗语说“七里山塘到虎丘”...',
						'picUrl' => 'http://thinkshare.duapp.com/images/suzhou.jpg',
						'url' =>'http://mp.weixin.qq.com/mp/appmsg/show?__biz=MjM5NDM0NTEyMg==&appmsgid=10000046&itemidx=1&sign=9e7707d5615907d483df33ee449b378d#wechat_redirect'
					);

					$resultStr = _response_news($postObj,$record);
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
}

?>