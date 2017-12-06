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

//引入回复消息的函数文件
require_once('includes/responseText.func.inc.php');

//引入函数文件
require_once('includes/weather/weather.func.inc.php');
require_once('includes/translate.func.inc.php');

//引入数据库文件
require_once('includes/mysql_bae.func.php');

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

					//判断用户状态
					$sql = "SELECT flag_id FROM user_flags WHERE from_user = '$fromUsername' LIMIT 0,1";
					$result = _select_data($sql);
					while (!!$rows = mysql_fetch_array($result))
					{
					  $user_flag = $rows[flag_id];
					}
					
					//如果用户输入“帮助”，则输出欢迎语，删除用户状态并直接退出
					if($keyword == "帮助" || $keyword == "菜单" || $keyword == "功能" || $keyword == "导航" || $keyword == "提示")
					{
						$contentStr = "感谢您关注【卓锦苏州】\n微信号：zhuojinsz\n请回复序号：\n1. 天气查询\n2. 翻译查询\n输入【帮助】查看提示\n更多内容，敬请期待...";
						echo _response_text($postObj,$contentStr);
						$sql = "DELETE FROM user_flags WHERE from_user = '$fromUsername'";
						_delete_data($sql);
						exit();
					}
					
					//判断用户存在的状态和新输入的状态，如果状态不一样，而且输入的keyword是数字，则设置$user_flag为空，数据库中清除状态，好像第一次查询流程
					if(trim($keyword) <> $user_flag && is_numeric($keyword))
					{
						$user_flag = '';
						$sql = "DELETE FROM user_flags WHERE from_user = '$fromUsername'";
						_delete_data($sql);
					}
					
					//用户状态为空，即第一次查询
					if (empty($user_flag))
					{
						switch ($keyword)
						{
							case 1:	//查询天气
								$sql = "insert into user_flags(from_user,flag_id) values('$fromUsername','1')";
								$contentStr = "请输入要查询天气的城市：如北京、上海、苏州";
								break;
							case 2:	//翻译
								$sql = "insert into user_flags(from_user,flag_id) values('$fromUsername','2')";
								$contentStr = "请输入要翻译的内容：如：早上好、good morning、おはよう";
								break;
							default: //其他
								$sql = "";
								$contentStr = "感谢您关注【卓锦苏州】\n微信号：zhuojinsz\n请回复序号：\n1. 天气查询\n2. 翻译查询\n输入【帮助】查看提示\n更多内容，敬请期待...";
								break;
						}
						
						//判断并执行上面的插入语句
						if (!empty($sql))
						{
							_insert_data($sql);
						}
						
					//用户状态不为空
					}else{
						if ($user_flag == '1')
						{
							$contentStr = _weather($keyword);	//查询天气
						}elseif ($user_flag == '2')
						{
							$contentStr = _baiduDic($keyword);	//翻译
						}
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