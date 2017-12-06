<?php

namespace weixin;

class wxMenu extends wxCURL
{
    private $create_menu_api = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=';
    private $delete_menu_api = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=';
    private $get_menu_api = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=';
    private $create_media_api = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token=';
    private $get_media_api = 'https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=';
    private $delete_media_api = 'https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=';
    private $create_image_api = 'https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=';
    private $token = '';

    public function __construct(){
        $this->token = wxToken::getToken();
        if (empty($this->token)) {
            exit('Error: get token failed.');
        }
    }
    public function createimage($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $curl_api =$this->create_image_api . $this->token;
        $ret = $this->post($curl_api,$data);
        return $ret;
    }
    public function deleteMedia()
    {
        $cur_api = $this->delete_media_api . $this->token;
        $ret = $this->get($cur_api);
        return $ret;
    }
    public function getlsMedia()
    {
        $data=[
            "type"=>'image',
            "offset"=>0,
            "count"=>15
        ];

        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->get_media_api . $this->token;
        $ret = $this->post($cur_api,$data);
        return $ret;
    }
    public function createMedia($menu){
        if( is_array($menu) ){
            $menu = json_encode($menu,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->create_media_api . $this->token;
        $ret = $this->upload($cur_api,$menu);
        return $ret;
    }
    public function getMenu()
    {
        $cur_api = $this->get_menu_api . $this->token;
        $ret = $this->get($cur_api);
        return $ret;
    }

    public function createMenu($menu)
    {
        if( is_array($menu) ){
            $menu = json_encode($menu,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->create_menu_api . $this->token;
        $ret = $this->post($cur_api,$menu);
        return $ret;
    }

    public function deleteMenu()
    {
        $cur_api = $this->delete_menu_api . $this->token;
        $ret = $this->get($cur_api);
        return $ret;
    }

}
