<?php
class searcherrcode
{
    public function SearErrCode($errcode)
    {
        switch($errcode)
        {
             case "EOL0500":
               $rescontent="|理论-反馈|>InposERRor";
               break;
             case "IOL0304":
               $rescontent="不是报错";
               break;
             case "WOL0120":
               $rescontent="不允许在辅助轴为执行状态下，给辅助轴一个运动指令";
               break;
             case "WOL0121":
               $rescontent="辅助轴没有进给倍率";
               break;
             case "EOL0002":
               $rescontent="编程指令坐标值超出了软限位";
               break;
             case "EOL0006":
               $rescontent="轴未挂载";
               break;
             case "EOL0900":
               $rescontent="主站网卡故障，用总线诊断工具检测总线当前状态";
               break;
             case "EOL0901":
               $rescontent="丢包，从站设备断电等，用总线诊断工具检测总线当前状态";
               break;
             case "EOL0902":
               $rescontent="从站设备推出OP，用总线诊断工具检测总线当前状态";
               break;
             case "EOL0910":
               $rescontent="用总线诊断工具检测总线当前状态";
               break;
             case "EOL0903":
               $rescontent="丢包，未开启实时通信，用总线诊断工具检测总线当前状态，检测system.ini开启实时通信";
               break;
             case "EOL0911":
               $rescontent="网线连接松动，网线问题，从站设备问题，外干扰等。用总线诊断工具检测总线当前状态，丢包诊断";
               break;
             case "EOL0904":
               $rescontent="网线连接松动，网线问题，从站设备问题，外干扰等。用总线诊断工具检测总线当前状态，丢包诊断";
               break;
             case "EOL0905":
               $rescontent="FPGA芯片运行出错；联系硬件开发人员，确定FPGA版本是否正确";
               break;
             case "EOL0906":
               $rescontent="总线诊断工具检测总线当前状态";
               break;
             case "IOL0900":
               $rescontent="不是报错";
               break;
             case "EOL7000":
               $rescontent="急停被拍下，取消急停状态";
               break;
             case "EOL7001":
               $rescontent="通常是发生外部IO严重错误，PLC请求CNC急停检测PLC";
               break;
             case "EOL7002":
               $rescontent="没有上电";
               break;
             case "EOL0002":
               $rescontent="编程位置超过安全限位，检查编程程序段";
               break;
             case "EOL0009":
               $rescontent="当轴卫浴软限位的时候，手摇轴会报错";
               break;
             case "EOL0007":
               $rescontent="当轴出现错误是，ctrl引脚为of";
               break;
             case "EOL0011":
               $rescontent="开机位置检测，当前位置和检测位置不一致，可能零点丢失。轴位置检测参数AXCHKABSPOS";
               break;
             case "EOL0004":
               $rescontent="跟随误差超过上限值";
               break;
             case "EOL0005":
               $rescontent="加速度误差超过上限值";
               break;
             case "EOL0044":
               $rescontent="AXFERROR>AXERRORLIMIT或AXFERROR>AXFERRORMAX";
               break;
             case "EOL0049":
               $rescontent="轴无法再指定时间内到达位置";
               break;
             case "EOL0104":
               $rescontent="ready引脚为of";
               break;
             case "EOL0003":
               $rescontent="error引脚为ON";
               break;
             case "EOL0016":
               $rescontent="不知道是哪个引脚或参数";
               break;
             default:
               $rescontent="暂无此故障号";
               break;
        }
    return $rescontent;
    }
}
?>