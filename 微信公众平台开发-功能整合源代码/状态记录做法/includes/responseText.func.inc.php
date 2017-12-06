<?php
/**
 * 微信公众平台-文本回复函数
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

function _response_text($object,$content){
	$textTpl = "<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				<FuncFlag>%d</FuncFlag>
				</xml>";
	$resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
	return $resultStr;
}

?>