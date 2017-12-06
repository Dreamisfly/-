<?php
/**
 * 微信公众平台-音乐回复函数
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

//引入数据库文件
require_once('mysql_bae.func.php');

function _response_music($object,$musicKeyword)
{
	$musicTpl = "<xml>
				 <ToUserName><![CDATA[%s]]></ToUserName>
				 <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[music]]></MsgType>
				 <Music>
				 <Title><![CDATA[%s]]></Title>
				 <Description><![CDATA[%s]]></Description>
				 <MusicUrl><![CDATA[%s]]></MusicUrl>
				 <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
				 </Music>
				 <FuncFlag>0</FuncFlag>
				 </xml>";

	$query = "SELECT * FROM tbl_music WHERE music_name LIKE '%$musicKeyword%'";
	$result = _select_data($query);
	$rows = mysql_fetch_array($result, MYSQL_ASSOC);
	
	$music_id = $rows[music_id];
	
	if($music_id <> '')
	{
		$music_name = $rows[music_name];
		$music_singer = $rows[music_singer];
		$musicUrl = "http://thinkshare.duapp.com/music/".$music_id.".mp3";
		$HQmusicUrl = "http://thinkshare.duapp.com/music/".$music_id.".mp3";
	
		$resultStr = sprintf($musicTpl, $object->FromUserName, $object->ToUserName, time(), $music_name, $music_singer, $musicUrl, $HQmusicUrl);
		return $resultStr;
	}else{
		return "";	
	}
}
?>