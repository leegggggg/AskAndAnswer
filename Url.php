<?php

include_once "WXBizMsgCrypt.php";

class ResponseUrl
{
	private $encodingAesKey = "GFAUkhjsjq1DdbBAK4ynSOqbahqVN4LKvS9V7LVmOIQ";  
	private $token = "i5cnctech";  
	private $corpId = "wxcd016c6dcaa0690a"; 
	private $sVerifyNonce;
	private $sVerifyMsgSig;
	private $sVerifyTimeStamp;
	public function _GetUrl()
	{
		// $sVerifyMsgSig = HttpUtils.ParseUrl("msg_signature");
    	$this->sVerifyMsgSig = $_GET['msg_signature'];
    	// $sVerifyTimeStamp = HttpUtils.ParseUrl("timestamp");
    	$this->sVerifyTimeStamp = $_GET['timestamp'];
    	// $sVerifyNonce = HttpUtils.ParseUrl("nonce");
    	$this->sVerifyNonce = $_GET['nonce'];
    	$sVerifyEchoStr = $_GET['echostr'];
    	$sEchoStr="";
    	$wxcpt = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId);
    	// $sVerifyEchoStr = HttpUtils.ParseUrl("echostr");
    	$errCode = $wxcpt->VerifyURL($this->sVerifyMsgSig, $this->sVerifyTimeStamp, $this->sVerifyNonce, $sVerifyEchoStr, $sEchoStr);
        if ($errCode == 0) 
    	{
	    	return $sEchoStr;
    	} 
    	else 
    	{
	    	print("ERR: " . $errCode . "\n\n");
    	}
    }
}

?>