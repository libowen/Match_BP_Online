<?php
/**
* FILE_NAME : housanlun.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\housanlun.php
* 最后三轮的操作,由于是最后三轮的编排，所以要在不同分的台次优先平衡高分项的先后手
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Thu Feb 04 16:49:27 CST 2010
*/

/**
* 功能：最后三轮的操作
* 参数：
* 返回：
*/
function housanlun($chengyuan,$saizhi=1){
   	      require_once(CLASS_PATH."public.php");
   	      $taicis=bp2330($chengyuan,$saizhi=1);
   	      //////////////////以上和ersipei()的相同，下面进行考虑优先配平高分的先后手////////////////////////////////
   	      /////对$taicis再次进行先后手的检验（xianhous来检验）和配列顺序的完善（两弃权的在最后一桌？！最后几桌按积分排？去高分项的积分先排，相同取另一项的积分去排，）
   	      //轮空必须是最低分者;非特殊情况不得三连先或三连后;
   	      //由于是最后三轮的编排，所以要在不同分的台次优先平衡高分项的先后手
   	      $taicis=ZLtaicis($taicis,1);//第二个参数表示是housanlun的编排
   	     
   	      return $taicis;
}


?>