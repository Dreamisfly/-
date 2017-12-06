<?php
/**
 * Created by PhpStorm.
 * User: zhangmengfei
 * Date: 2017/11/30
 * Time: 15:40
 */

namespace weixin;


class wxKefu extends wxCURL
{
     //获取客服基本信息（详细）
    private $get_kefu_url = 'https://api.weixin.qq.com/cgi-bin/customservice/getkflist?access_token=';
    //获取客服基本信息
    private $get_kefu1_url = 'https://api.weixin.qq.com/cgi-bin/customservice/getonlinekflist?access_token=';
    //添加客服账号
    private $create_kefu_url = 'https://api.weixin.qq.com/customservice/kfaccount/add?access_token=';
    //邀请绑定客服账号
    private $bind_kefu_url = 'https://api.weixin.qq.com/customservice/kfaccount/inviteworker?access_token=';
    //上传客服头像
    private $upload_kefu_url = 'https://api.weixin.qq.com/customservice/kfaccount/uploadheadimg?access_token=';
    private $delete_kefu_url = 'https://api.weixin.qq.com/customservice/kfaccount/del?access_token=';
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
    public function getkefu()
    {
        $this->curl_api = $this->get_kefu_url . $this->token;
        return $this->get($this->curl_api);
    }
    public function getkefu1()
    {
        $this->curl_api = $this->get_kefu1_url . $this->token;
        return $this->get($this->curl_api);
    }
    public function createkefu($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $this->curl_api = $this->create_kefu_url . $this->token;
        return $this->post($this->curl_api, $data);
    }
    public function bindkefu($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $this->curl_api = $this->bind_kefu_url . $this->token;
        return $this->post($this->curl_api, $data);
    }
    public function uploadheadimg($kf_account,$data)
    {

        $this->curl_api = $this->upload_kefu_url . $this->token . '&kf_account=' .$kf_account;
        return $this->upload($this->curl_api,$data,'media');
    }
    public function deletekefu($kf_account)
    {
        $this->curl_api = $this->delete_kefu_url . $this->token . '&kf_account=' .$kf_account;
        return $this->get($this->curl_api);
    }

}