<?php
include 'Url.php';
include 'menu.php';
include 'responcemsg.php';
header("Content-Type: text/html; charset=UTF-8");
$NeedUrl=$_GET['echostr'];
if ( $NeedUrl != "")
{
	$RESURL=new ResponseUrl();
    $URL_RESULT=$RESURL->_GetUrl();
    echo $URL_RESULT;	
}
else 
{
	$CREMENU=new CreatMenu();
    $result_menu=$CREMENU->_GetMenu();
    echo $result_menu;
	$RESMSG=new ResponceMsg();
    $MSG_RESULT=$RESMSG->_GetMsg();
    echo $MSG_RESULT;	
}

//error_log($result_menu,3,"E:\wamp\www\log.txt");
?>
