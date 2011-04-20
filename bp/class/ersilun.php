<?php
/**
* FILE_NAME : ersilun.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\ersilun.php
* 第二轮到倒数第四轮的编排
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Thu Feb 04 16:31:18 CST 2010
*/


/**
* 功能：第二轮到倒数第四轮的编排
* 参数：$chengyuan 数据库中获取的以编号顺序的的数组【且包含$chengyuan[][xs_banqu]的字段】；
       $saizhi 具体的赛制和编排方式：是否考虑平衡先后手，是否支持连三；  目前不考虑
       $tiao 是否考虑上下调的次数：考虑，不考虑，考虑连二；             目前不考虑
* 返回：配对好的 2维+多维数组$taicis
*/
function ersilun($chengyuan,$saizhi){
   	      require_once(CLASS_PATH."public.php");
   	      
   	      $taicis=bp2330($chengyuan,$saizhi=1);
   	      /////对$taicis再次进行先后手的检验（xianhous来检验）和配列顺序的完善（两弃权的在最后一桌？！最后几桌按积分排？去高分项的积分先排，相同取另一项的积分去排，）
   	      //轮空必须是最低分者;非特殊情况不得三连先或三连后;首
   	      $taicis=ZLtaicis($taicis);
   	      return $taicis;
}


?>