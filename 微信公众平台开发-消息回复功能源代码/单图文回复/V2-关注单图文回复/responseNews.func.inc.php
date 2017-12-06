<?php
/**
 * 微信公众平台-图文回复函数
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

/**
 * _response_news() 返回图文格式信息
 * @param $object 消息类型
 * @param $newsContent 消息内容
 * 传入数组格式
 * $record=array(
		'title' =>'观前街',
		'description' =>'观前街位于江苏苏州市区，是成街于清朝时期的百年商业老街，街上老店名店云集，名声远播海内外...',
		'picUrl' => 'http://joythink.duapp.com/images/suzhou.jpg',
		'url' =>'http://www.joythink.net'
	);
 * @return 处理过的具有格式的图文消息
 */
function _response_news($object,$newsContent)
{
	$newsTplHead = "<xml>
				    <ToUserName><![CDATA[%s]]></ToUserName>
				    <FromUserName><![CDATA[%s]]></FromUserName>
				    <CreateTime>%s</CreateTime>
				    <MsgType><![CDATA[news]]></MsgType>
				    <ArticleCount>1</ArticleCount>
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

	$header = sprintf($newsTplHead, $object->FromUserName, $object->ToUserName, time());
  
	$title = $newsContent['title'];
	$desc = $newsContent['description'];
	$picUrl = $newsContent['picUrl'];
	$url = $newsContent['url'];
	$body = sprintf($newsTplBody, $title, $desc, $picUrl, $url);

	$FuncFlag = 0;
	$footer = sprintf($newsTplFoot, $FuncFlag);

	return $header.$body.$footer;
}

?>