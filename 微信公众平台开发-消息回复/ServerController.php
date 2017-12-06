<?php
/**
 * Created by PhpStorm.
 * User: ll
 * Date: 2017/11/20
 * Time: 8:21
 */

namespace app\index\controller;

use think\Controller;

class ServerController extends Controller
{
    //填写微信公众号设置好的token
    private $token = 'zhangmengfei';

    private $textTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            </xml>";
    private $imageTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Image>
            <MediaId><![CDATA[%s]]></MediaId>
            </Image>
            </xml>";
    private $voiceTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType>
            <Voice>
            <MediaId><![CDATA[%s]]></MediaId>
            </Voice>
            </xml>";
    private $newsTpl = "<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType>%s</MsgType>
            <ArticleCount>%s</ArticleCount>
            <Articles>%s</Articles>
            </xml>'";
    private $new_itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
    private $msgTpl='';
    private $msgType = 'text';
    //验证流程开始
    private function checkSignature()
    {
        $signature = request_data('get','signature');
        $timestamp = request_data('get','timestamp');
        $nonce = request_data('get','nonce');
        $tmpArr = array($this->token, $timestamp, $nonce);
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
        $echoStr = request_data('get','echostr');
        if($this->checkSignature()){
            exit($echoStr);
        }
    }
    //end
    public function index()
    {
        $w = new ServerController();
        //$w->valid();
        $w->responseMsg();
    }
    public function responseMsg()
    {
        $postStr = file_get_contents('php://input', 'r');
        if (!empty($postStr)) {
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            //把 PHP对象的变量转换成关联数组
            if( strtolower( $postObj->MsgType) == 'event'){
                //如果是关注事件(subscribe)
                if( strtolower($postObj->Event == 'subscribe') ){
                    //回复用户消息
                    $toUser   = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time     = time();
                    $msgType  =  'text';
                    $content  = '欢迎关注 DreamisFly 微信公众账号'.$postObj->FromUserName.'-'.$postObj->ToUserName;
                    $template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
                    $info     = sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
                    echo $info;
                }
            }
            if(($postObj->MsgType) == 'text' && trim($postObj->Content) == 'search'){
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $arr = array(
                    array(
                        'title'=>'夏目友人帐',
                        'description'=>"此生无悔入夏目",
                        'picUrl'=>'http://img4.duitang.com/uploads/item/201508/16/20150816015528_X8dKY.jpeg',
                        'url'=>'http://www.shulvchen.cn',
                    ), array(
                        'title'=>'夏目友人帐',
                        'description'=>"此生无悔入夏目",
                        'picUrl'=>'http://img4.duitang.com/uploads/item/201508/16/20150816015528_X8dKY.jpeg',
                        'url'=>'http://www.shulvchen.cn',
                    ),
                );
                $template = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>".count($arr)."</ArticleCount>
						<Articles>";
                foreach($arr as $k=>$v){
                    $template .="<item>
							<Title><![CDATA[".$v['title']."]]></Title> 
							<Description><![CDATA[".$v['description']."]]></Description>
							<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
							<Url><![CDATA[".$v['url']."]]></Url>
							</item>";
                }
                $template .="</Articles>
						</xml> ";
                echo sprintf($template, $toUser, $fromUser, time(), 'news');
            }
//回复纯文本或单图文消息
            if((($postObj->MsgType) == 'text' && trim($postObj->Content) == 'get1') || (($postObj->MsgType) == 'text' && trim($postObj->Content) == 'get2')){
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $arr = array(
                    array(
                        'title'=>'夏目友人帐',
                        'description'=>"此生无悔入夏目",
                        'picUrl'=>'http://img4.duitang.com/uploads/item/201508/16/20150816015528_X8dKY.jpeg',
                        'url'=>'http://www.shulvchen.cn',
                    ),
                );
                $template = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>".count($arr)."</ArticleCount>
						<Articles>";
                foreach($arr as $k=>$v){
                    $template .="<item>
							<Title><![CDATA[".$v['title']."]]></Title> 
							<Description><![CDATA[".$v['description']."]]></Description>
							<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
							<Url><![CDATA[".$v['url']."]]></Url>
							</item>";
                }
                $template .="</Articles>
						</xml> ";
                echo sprintf($template, $toUser, $fromUser, time(), 'news');
            }else{
                switch( trim($postObj->Content) ){
                    case 'hello':
                        $content = 'hi';
                        break;
                    case 'hi':
                        $content = 'hi';
                        break;
                    case 'help':
                        $content = '加油';
                        break;
                    case '帮助':
                        $content = "<a href='http://zmfei.wywwwxm.com/index/help/index'>帮助页面(点击文字，进入帮助页面)</a>";
                        break;
                    case '杨思琪':
                        $content = '爸爸爱你';
                        break;
                    case '你是机器人么':
                        $content = '我是机器人，但是我是智能的';
                        break;
                    case '哈哈':
                        $content = '你傻笑什么';
                        break;
                    default:
                        $content = "<a href='http://www.baidu.com'>百度一下，你就知道(点击文字，进入百度)</a>";

                }
                $template1 = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							</xml>";
                $fromUser = $postObj->ToUserName;//消息从哪里来
                $toUser   = $postObj->FromUserName;//发送给谁
                $time     = time();
                //$content  = '我喜欢你';
                $msgType  = 'text';
                echo sprintf($template1, $toUser, $fromUser,$time, $msgType, $content);
            }

            //预处理方法进行消息处理
        }
    }
}

//获取GET/POST数据，type:get/post
//ind:数组索引；dval：默认值，没有此参数则返回默认值
function request_data($type,$ind,$dval=''){
    $type=strtolower($type);
    if(empty($ind) || !is_string($ind)){
        return $dval;
    }
    if($type=='get'){
        return (isset($_GET[$ind])?$_GET[$ind]:$dval);
    }
    elseif($type=='post'){
        return (isset($_POST[$ind])?$_POST[$ind]:$dval);
    }
    return $dval;
}