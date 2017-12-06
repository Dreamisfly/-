<?php
/**
 * Created by PhpStorm.
 * User: zhangmengfei
 * Date: 2017/11/30
 * Time: 16:06
 */

namespace weixin;


class wxTalk extends wxCURL
{
    //创建会话
    private $create_talk_url = 'https://api.weixin.qq.com/customservice/kfsession/create?access_token=';
    //关闭会话
    private $close_talk_url = 'https://api.weixin.qq.com/customservice/kfsession/close?access_token=';
    //获取客户会话状态
    private $get_talk_url = 'https://api.weixin.qq.com/customservice/kfsession/getsession?access_token=';
    //获取客服会话列表
    private $get_talklist_url = 'https://api.weixin.qq.com/customservice/kfsession/getsessionlist?access_token=';
    private $get_waitcase_url = 'https://api.weixin.qq.com/customservice/kfsession/getwaitcase?access_token=';
    private $curl_api = '';
    private $token = '';

    public function __construct()
    {
        $this->token = wxToken::getToken();
        //如果获取失败则退出并返回错信息
        if (empty($this->token)) {
            exit('Error: get token failed.');
        }
    }
    public function createtalk($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $this->curl_api = $this->create_talk_url . $this->token;
        return $this->post($this->curl_api, $data);
    }
    public function closetalk($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $this->curl_api = $this->close_talk_url . $this->token;
        return $this->post($this->curl_api, $data);
    }
    public function gettalk($openid)
    {
        $this->curl_api = $this->get_talk_url . $this->token . '&openid=' .$openid;
        return $this->get($this->curl_api);
    }
    public function gettalklist($kf_account)
    {
        $this->curl_api = $this->get_talklist_url . $this->token . '&kf_account=' .$kf_account;
        return $this->get($this->curl_api);
    }
    public function getwaitcase()
    {
        $this->curl_api = $this->get_waitcase_url . $this->token;
        return $this->get($this->curl_api);
    }

}