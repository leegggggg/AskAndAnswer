<?php 
$item_str="";
$itemTpl = "        <item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
        </item>
        ";
$newsArray=array();
$newsArray[]=array("Title"=>"技术支持部", "Description"=>"这是一个测试", "PicUrl"=>"http://j3mkit.natappfree.cc/res/timg.jpg", "Url" =>"http://doc.i5cnc.com/");
foreach ($newsArray as $item){
	echo $item;
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        }
?>