<?php
include 'access_token.php';
//header("Content-Type: text/html; charset=UTF-8");
class CreatMenu
{
	public function _GetMenu()
	{
		$GetAccess=new AccessToken();
		$access_token=$GetAccess->_GetToken();
		$AppID="41";
		$url="https://qyapi.weixin.qq.com/cgi-bin/menu/create?access_token={$access_token}&agentid={$AppID}";
		error_log($url,3,"E:\wamp\www\log.txt");
		$CreMenu['button']['0']['name'] = '扫一扫';
		$CreMenu['button']['0']['sub_button']['0']['name'] = '现场扫码';
        $CreMenu['button']['0']['sub_button']['0']['type']  = 'scancode_waitmsg';
        $CreMenu['button']['0']['sub_button']['0']['key']  = 'HavePeople';
        $CreMenu['button']['0']['sub_button']['1']['name'] = '图片扫码';
        $CreMenu['button']['0']['sub_button']['1']['type']  = 'scancode_waitmsg';
        $CreMenu['button']['0']['sub_button']['1']['key']  = 'NoPeople';
        $CreMenu['button']['1']['name'] = '人工服务';
		$CreMenu['button']['1']['sub_button']['0']['name'] = '有二维码';
        $CreMenu['button']['1']['sub_button']['0']['type']  = 'scancode_waitmsg';
        $CreMenu['button']['1']['sub_button']['0']['key']  = 'HavePicture';
        $CreMenu['button']['1']['sub_button']['1']['name'] = '无二维码';
        $CreMenu['button']['1']['sub_button']['1']['type']  = 'scancode_waitmsg';
        $CreMenu['button']['1']['sub_button']['1']['key']  = 'NoPicture';
        $CreMenu['button']['2']['name'] = '紧急报修';
        $CreMenu['button']['2']['type'] = 'click';
        $CreMenu['button']['2']['key'] = 'Tel';
        $Menu_Result=json_encode($CreMenu,JSON_UNESCAPED_UNICODE);
        //error_log($Menu_Result,3,"E:\wamp\www\log.txt");
        $ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $Menu_Result);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$a = curl_exec($ch);
		//error_log($a,3,"E:\wamp\www\log.txt");
		curl_close($ch);
		return $a;
	}
}

 
?>
