<?php
class PrintLog
{
	public function nlogger($Msg)
	{ 
		error_log($Msg,3,"E:\wamp\www\log.txt");
	}
}
?>