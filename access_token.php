<?php
class AccessToken
{

	//private $_token;
	public function _GetToken()
	{ 
		$appid = "wxf39202c972c987ec";
        $appsecret = "5X0o47_KS2RrzusyGDi9Kpkn5qFX9XbrktO-tIT9_nOIYWX5fTLY3VFq8Auc2_ux";
		$url ="https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$appid}&corpsecret={$appsecret}";
		//error_log($url,3,"E:\wamp\www\log.txt");
		$ch = curl_init();	
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$a = curl_exec($ch);
		//error_log($a,3,"E:\wamp\www\log.txt");
		curl_close($ch);
		$strjson=json_decode($a);
		$token = $strjson->access_token;
		error_log($token,3,"E:\wamp\www\access_token.txt");
		$deadtime = $strjson->expires_in;
		error_log($deadtime,3,"E:\wamp\www\access_token.txt");
	    return $token;
	}
}
?>