<?php
/**
 * 微信公众平台-多图文回复函数
 * ================================
 * Copyright 2013-2014 David Tang
 * http://www.cnblogs.com/mchina/
 * http://www.joythink.net/
 * ================================
 * Author:David
 * 个人微信：mchina_tang
 * 公众微信：zhuojinsz
 * Date:2013-10-11
 */

/**
 * _response_news() 返回多图文格式信息
 * @param $object 消息类型
 * @param $newsContent 消息内容
 * 传入数组格式（多维数组）
	Array
	(
		[0] => Array
			(
				[title] => 观前街
				[description] => 观前街位于江苏苏州市区...
				[picUrl] => http://joythink.duapp.com/images/suzhou.jpg
				[url] => http://mp.weixin.qq.com
			)

		[1] => Array
			(
				[title] => 拙政园
				[description] => 拙政园位于江苏省苏州市平江区...
				[picUrl] => http://joythink.duapp.com/images/suzhouScenic/zhuozhengyuan.jpg
				[url] => http://mp.weixin.qq.com
			)

	)
 * @return 处理过的具有格式的多图文消息
 */
function _response_multiNews($object,$newsContent)
{
	$newsTplHead = "<xml>
				    <ToUserName><![CDATA[%s]]></ToUserName>
				    <FromUserName><![CDATA[%s]]></FromUserName>
				    <CreateTime>%s</CreateTime>
				    <MsgType><![CDATA[news]]></MsgType>
				    <ArticleCount>%s</ArticleCount>
				    <Articles>";
	$newsTplBody = "<item>
				    <Title><![CDATA[%s]]></Title> 
				    <Description><![CDATA[%s]]></Description>
				    <PicUrl><![CDATA[%s]]></PicUrl>
				    <Url><![CDATA[%s]]></Url>
				    </item>";
	$newsTplFoot = "</Articles>
					<FuncFlag>0</FuncFlag>
				    </xml>";

	$bodyCount = count($newsContent);
	$bodyCount = $bodyCount < 10 ? $bodyCount : 10;

	$header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time(), $bodyCount);
	
	foreach($newsContent as $key => $value){
		$body .= sprintf($newsTplBody, $value['title'], $value['description'], $value['picUrl'], $value['url']);
	}

	$FuncFlag = 0;
	$footer = sprintf($newsTplFoot, $FuncFlag);

	return $header.$body.$footer;
}

?>