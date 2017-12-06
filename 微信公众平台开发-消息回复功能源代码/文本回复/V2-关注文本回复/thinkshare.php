<?php
/**
 * 微信公众平台-文本回复功能源代码
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
				$RX_TYPE = trim($postObj->MsgType);

				switch($RX_TYPE)
				{
					case "text":
						$resultStr = $this->handleText($postObj);
						break;
					case "event":
						$resultStr = $this->handleEvent($postObj);
						break;
					default:
						$resultStr = "Unknow msg type: ".$RX_TYPE;
						break;
				}
				echo $resultStr;
		}else{
			echo "";
			exit;
		}
	}

	public function handleText($postObj)
    {
        $keyword = trim($postObj->Content);

        if(!empty( $keyword ))
        {
            $contentStr = "微信公众平台-文本回复功能源代码";
            //$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			$resultStr = _response_text($postObj,$contentStr);
            echo $resultStr;
        }else{
            echo "Input something...";
        }
    }

    public function handleEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【卓锦苏州】"."\n"."微信号：zhuojinsz";
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;
                break;
        }
        $resultStr = _response_text($object, $contentStr);
        return $resultStr;
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