<?php
/**
 * Created by PhpStorm.
 * User: zhangmengfei
 * Date: 2017/11/6
 * Time: 9:35
 */
namespace weixin;
class wxUser extends wxCURL
{
    //创建标签
    private $create_tag_api = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token=';
    //创建昵称
    private $update_remark_api = 'https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=';
    //获取用户信息
    private $get_userInfo_api = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=';
    //获取标签
    private $get_tag_api = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token=';
    //更新标签
    private $update_tag_api = 'https://api.weixin.qq.com/cgi-bin/tags/update?access_token=';
    //删除标签
    private $delete_tag_api = 'https://api.weixin.qq.com/cgi-bin/tags/delete?access_token=';
    //获取粉丝
    private $get_fans_api = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token=';
    //获取用户列表
    private $get_userLists_api = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token=';
    //获取黑名单
    private $get_blackList_api = 'https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=';
    //拉黑用户
    private $batch_blackList_api='https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=';
    //取消拉黑用户
    private $batchun_blackList_api = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=';
    private $token = '';
    public function __construct(){
        $this->token = wxToken::getToken();
        if (empty($this->token)) {
            exit('Error: get token failed.');
        }
    }
    public function createTag($tag)
    {
        if( is_array($tag) ){
            $tag = json_encode($tag,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->create_tag_api . $this->token;
        $ret = $this->post($cur_api,$tag);
        return $ret;
    }
    public function updateRemake($remark)
    {
        if( is_array($remark) ){
            $remark = json_encode($remark,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->update_remark_api . $this->token;
        $ret = $this->post($cur_api,$remark);
        return $ret;
    }
    public function getUserInfo($openid)
    {
        $cur_api = $this->get_userInfo_api . $this->token .'&openid='.$openid.'&lang=zh_CN';
        $ret = $this->get($cur_api);
        return $ret;
    }
    public function getTag()
    {
        $cur_api = $this->get_tag_api . $this->token;
        $ret = $this->get($cur_api);
        return $ret;
    }
    public function updateTag($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->update_tag_api . $this->token;
        $ret = $this->post($cur_api,$data);
        return $ret;
    }
    public function deleteTag()
    {
        $cur_api = $this->delete_tag_api . $this->token;
        $ret = $this->get($cur_api);
        return $ret;
    }

    /**
     * @param $data
     * POST数据格式：JSON
     *POST数据例子：
     *{
     *"tagid" : 134,
     *"next_openid":""//第一个拉取的OPENID，不填默认从头开始拉取
     *}
     * @return mixed
     */
    public function getFans($data)
    {
        if( is_array($data) ){
            $data = json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->get_fans_api . $this->token;
        $ret = $this->post($cur_api,$data);
        return $ret;
    }

    /**
     * @param $next_openid 下一个openid
     * @return mixed
     */
    public function getuserLists($next_openid)
    {
        $cur_api = $this->get_userLists_api . $this->token .'&next_openid='.$next_openid;
        $ret = $this->get($cur_api);
        return $ret;
    }

    /**
     * @param $begin_openid 黑名单列表由一串 OpenID （加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成。
     * 当begin_openid 为空时，默认从开头拉取。
     * @return mixed
     */
    public function getblackList($begin_openid)
    {
        if( is_array($begin_openid) ){
            $begin_openid = json_encode($begin_openid,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->get_blackList_api . $this->token;
        $ret = $this->post($cur_api,$begin_openid);
        return $ret;
    }

    /**
     * @param $openid_list  openid列表
     * @return mixed
     */
    public function batchblackList($openid_list)
    {
        if( is_array($openid_list) ){
            $openid_list = json_encode($openid_list,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->batch_blackList_api . $this->token;
        $ret = $this->post($cur_api,$openid_list);
        return $ret;
    }
    /**
     * @param $openid_list  openid列表
     * @return mixed
     */
    public function batchunblackunList($openid_list)
    {
        if( is_array($openid_list) ){
            $openid_list = json_encode($openid_list,JSON_UNESCAPED_UNICODE);
        }
        $cur_api = $this->batchun_blackList_api . $this->token;
        $ret = $this->post($cur_api,$openid_list);
        return $ret;
    }
}