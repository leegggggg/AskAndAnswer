<?php
include_once "WXBizMsgCrypt.php";
include_once 'searerrcode.php';
class ResponceMsg
{
	private $encodingAesKey = "GFAUkhjsjq1DdbBAK4ynSOqbahqVN4LKvS9V7LVmOIQ";  
	private $token = "i5cnctech";  
	private $corpId = "wxcd016c6dcaa0690a";
	public function _GetMsg()
	{
		$wxcpt = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId); 
		$sReqMsgSig = $_GET['msg_signature'];
		$sReqTimeStamp = $_GET['timestamp'];
		$sReqNonce = $_GET['nonce'];
		$sReqData = $GLOBALS["HTTP_RAW_POST_DATA"];
		$sMsg = "";
		$errCode = $wxcpt->DecryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
	    if ($errCode == 0) 
	    {
	    	$MsgStr=$sMsg;
	    	$fromUsername = $MsgStr->FromUserName;  
            $toUsername = $MsgStr->ToUserName;  
            $time = time();  
	    }
		if (!empty($MsgStr))
		{
            $MsgObj = simplexml_load_string($MsgStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $msg_type = $MsgObj->MsgType;
            echo $msg_type;
            switch ($msg_type)
            {
            	case "event";
            	    $result=$this->receiveEvent($MsgObj);
            	    break;
            	default:
                    $result = "unknown msg type: ".$msg_type;
                    break;
            }
            echo $result; 
		}
	}
	private function receiveEvent($object)
    {
        $content = "";
        //error_log($object->Event,3,"E:\wamp\www\log.txt");
        switch ($object->Event)
        {
            case "subscribe":
                $content = "欢迎使用i5企业号";
                $content .= (!empty($object->EventKey))?("\n来自二维码场景 ".str_replace("qrscene_","",$object->EventKey)):"";
				$content .= "\n\n".'<a href="http://i5cnc.com">技术支持部</a>';
                break;
            case "unsubscribe":
                $content = "取消关注";
                break;
            case "click":
                switch ($object->EventKey)
                {              	
                    case "ServeIn":
                        $content = array();
                        $content[] = array("Title"=>"技术支持部", "Description"=>"这是一个测试", "PicUrl"=>"http://j3mkit.natappfree.cc/res/timg.jpg", "Url" =>"http://doc.i5cnc.com/");
                        break;
                    default:
                        $content = "点击菜单：".$object->EventKey;
                        break;
                }
                break;
            case "VIEW":
                $content = "跳转链接 ".$object->EventKey;
                break;
            case "SCAN":
                $content = "扫描场景 ".$object->EventKey;
                break;
            case "LOCATION":
                //$content = "上传位置：纬度 ".$object->Latitude.";经度 ".$object->Longitude;
                break;
            case "scancode_waitmsg":
                if ($object->ScanCodeInfo->ScanType == "qrcode"){
                	$SearErr = new searcherrcode();
                	$ErrResult = $SearErr->SearErrCode($object->ScanCodeInfo->ScanResult);
                    //$content = "扫码带提示：类型 二维码 结果：".$object->ScanCodeInfo->ScanResult;
                    $content = "扫码带提示：类型 二维码 结果：".$ErrResult;
                }else if ($object->ScanCodeInfo->ScanType == "barcode"){
                    $codeinfo = explode(",",strval($object->ScanCodeInfo->ScanResult));
                    $codeValue = $codeinfo[1];
                    $content = "扫码带提示：类型 条形码 结果：".$codeValue;
                }else{
                    $content = "扫码带提示：类型 ".$object->ScanCodeInfo->ScanType." 结果：".$object->ScanCodeInfo->ScanResult;
                }
                break;
            case "scancode_push":
                $content = "扫码推事件";
                break;
            case "pic_sysphoto":
                $content = "系统拍照";
                break;
            case "pic_weixin":
                $content = "相册发图：数量 ".$object->SendPicsInfo->Count;
                break;
            case "pic_photo_or_album":
                $content = "拍照或者相册：数量 ".$object->SendPicsInfo->Count;
                break;
            case "location_select":
                $content = "发送位置：标签 ".$object->SendLocationInfo->Label;
                break;
            case "enter_agent":
            	$content = "欢迎使用i5技术支持应用";
            	break;
            default:
                $content = "receive a new event: ".$object->Event;
                break;
        }

        if(is_array($content)){
            $result = $this->transmitNews($object, $content);
            //error_log("进入推送",3,"E:\wamp\www\log.txt");
        }else{
            $result = $this->transmitText($object, $content);
        }
        return $result;
    }
    //回复文本消息
    private function transmitText($object, $content)
    {
        if (!isset($content) || empty($content)){
            return "";
        }

        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
    	<FromUserName><![CDATA[%s]]></FromUserName>
    	<CreateTime>%s</CreateTime>
    	<MsgType><![CDATA[text]]></MsgType>
    	<Content><![CDATA[%s]]></Content>
        </xml>";
        $sRespData = sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        $sEncryptMsg = "";
        $wxcpt = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId);
        $errCode = $wxcpt->EncryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $sEncryptMsg);
        //echo $sEncryptMsg;
        return $sEncryptMsg;
    }
    //回复图文消息
    private function transmitNews($object, $newsArray)
    {
        if(!is_array($newsArray)){
            return "";
        }
        $itemTpl = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
        ";
        $item_str = "";
        foreach ($newsArray as $item){
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
        $sEncryptMsg = "";
        $wxcpt = new WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->corpId);
        $xmlTpl = "<xml>
        <ToUserName><![CDATA[%s]]></ToUserName>
        <FromUserName><![CDATA[%s]]></FromUserName>
        <CreateTime>%s</CreateTime>
        <MsgType><![CDATA[news]]></MsgType>
        <ArticleCount>%s</ArticleCount>
        <Articles>
        $item_str    </Articles>
        </xml>";
        $sRespData= sprintf($xmlTpl, $object->FromUserName, $object->ToUserName, time(), count($newsArray));
        error_log($_GET['timestamp'],3,"E:\wamp\www\log.txt");
        $errCode = $wxcpt->EncryptMsg($sRespData, $_GET['timestamp'], $_GET['nonce'], $sEncryptMsg);
        //echo $sEncryptMsg;
        return $sEncryptMsg;
    }
}