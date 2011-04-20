<?php
/**
* FILE_NAME : zuihoulun.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\zuihoulun.php
* 最后一轮的操作，先后手尽量只多一先或多一后，优先配平高分项的先后手，最充分配对近分项即使多三先或多三后！！
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Thu Feb 04 16:50:26 CST 2010
*/



/**
* 功能：最后一轮的操作，先后手尽量只多一先或多一后，优先配平高分项的先后手，最充分配对近分项即使多三先或多三后！！
* 参数：
* 返回：
*/
function zuihoulun($chengyuan,$saizhi=1){
	//同后三轮，但还可以允许连三的出现，使用手动修改即可
	   	  require_once(CLASS_PATH."public.php");
   	      $taicis=bp2330($chengyuan,$saizhi=1);
   	      //////////////////以上和ersipei()的相同，下面进行考虑优先配平高分的先后手////////////////////////////////
   	      /////对$taicis再次进行先后手的检验（xianhous来检验）和配列顺序的完善（两弃权的在最后一桌？！最后几桌按积分排？去高分项的积分先排，相同取另一项的积分去排，）
   	      //轮空必须是最低分者;非特殊情况不得三连先或三连后;
   	      //由于是最后三轮的编排，所以要在不同分的台次优先平衡高分项的先后手
   	      $taicis=ZLtaicis($taicis,1);//第二个参数表示是housanlun的编排
   	     
   	      return $taicis;
/* 
  	      require_once(CLASS_PATH."public.php");
   	      $fd=fenzupaixu($chengyuan);
   	      $taicis=array();
   	      $yus=array();
   	      $fanhui=array();
   	      
   	      foreach ($fd as $key => $value) {
   	      	isset($value[0][0]['xs_zongfen'])?$benfen=$value[0][0]['xs_zongfen']:$benfen=$value[1][0]['xs_zongfen'];//或取本分段的本来积分
   	      	$benfen=(isset($value[0][0]['xs_zongfen'])?$value[0][0]['xs_zongfen']:$value[1][0]['xs_zongfen']);//或取本分段的本来积分
//   	    echo '<br>每个分数段：'.$benfen;if ($benfen==0) {print_r($value);   	    }
   	      	$fanhui=yipei($value,$yus,$benfen);
   	      	$peiduis=$fanhui[0];
   	      	
   	      	if ($key==count($fd)-1) {//最后一个分段
	                if ((count($fanhui[1][0])+count($fanhui[1][1]))) {
		   	      		$fanhui=erpei2($fanhui[1],$taicis,$benfen);
		   	      		//本次操作所配得的配对数组$fanhui[0] [0]/[1]，$fanhui[1]=向上拆对数
		   	      		$taicis=array_hebing(array_slice($taicis,0,(count($taicis)-$fanhui[1])),$fanhui[0]);
		   	      	}else{
		   	      	    $taicis=array_hebing($taicis,$peiduis);	
		   	      	}
   	      	}else{
		   	      	if ((count($fanhui[1][0])+count($fanhui[1][1]))>1) {
		   	      		$fanhui=erpei($fanhui[1],$fanhui[0],$benfen);
		   	      		//本次操作所配得的配对数组$fanhui[0][第几对] [0]/[1]，剩余项数组$fanhui[1] [0]/[1] [第几项] ，$fanhui[2]=剩余项个数，$fanhui[3]=上拆对数]
		   	      		$weichais=array_slice($peiduis,0,(count($peiduis)-$fanhui[3]));//没拆到得本分段已配的对
		   	      		$peiduis=array_hebing($weichais,$fanhui[0]);
		   	      	}
	   	      		$yus=$fanhui[1]; //可能为空数组
	   	      		$taicis=array_hebing($taicis,$peiduis);
   	      	}
   	      }
*/
   	      /////对$taicis再次进行先后手的检验（xianhous来检验）和配列顺序的完善（两弃权的在最后一桌？！最后几桌按积分排？去高分项的积分先排，相同取另一项的积分去排，）
   	      //轮空必须是最低分者;非特殊情况不得三连先或三连后;首
   	      /*
   	      $jifen1=array();
   	      $jifen2=array();
   	      foreach ($taicis as $key => $value) {
	   	      	if ($value[0]['xs_zongfen']>$value[1]['xs_zongfen']) {
		   	      	$jifen1[]=$value[0]['xs_zongfen'];
		   	      	$jifen2[]=$value[1]['xs_zongfen'];
	   	      	}else{
		   	      	$jifen1[]=$value[1]['xs_zongfen'];
		   	      	$jifen2[]=$value[0]['xs_zongfen'];
	   	      	}
   	      	    if ($value[0]['xs_xianshu']>$value[1]['xs_xianshu']) {
   	      	    	$taicis[$key][0]=$value[1];
   	      	    	$taicis[$key][1]=$value[0];
   	      	    }elseif ($value[0]['xs_xianshu']==$value[1]['xs_xianshu']){
   	      	    	//-大于+，而且已经反转字符串，大于就不用换位置了，小于才直接换位
   	      	    	$linshi=strcmp(strrev($value[0]['xs_xianhous']),strrev($value[1]['xs_xianhous']));
   	      	    	if ($linshi<0) {
	   	      	    	$taicis[$key][0]=$value[1];
	   	      	    	$taicis[$key][1]=$value[0];
   	      	    	}elseif ($linshi==0){
	   	      	    	//还没分出，单轮小号先，双轮大号先
	   	      	    	$lunci=substr_count($taicis[0][0]['xs_towhos'],',')/2+1;//正在编排的轮次
	   	      	    	if ($lunci%2) {//单轮
	   	      	    		if ($value[0]['xs_xuhao']>$value[1]['xs_xuhao']) {
			   	      	    	$taicis[$key][0]=$value[1];
			   	      	    	$taicis[$key][1]=$value[0];
	   	      	    		}
	   	      	    	}else{//双轮
	   	      	    		if ($value[0]['xs_xuhao']<$value[1]['xs_xuhao']) {
			   	      	    	$taicis[$key][0]=$value[1];
			   	      	    	$taicis[$key][1]=$value[0];
	   	      	    		}
	   	      	    	}	
   	      	    	}
   	      	    }
   	      }
   	      array_multisort($jifen1,SORT_DESC,$jifen2,SORT_DESC,$taicis);
   	      return $taicis;
   	      */
}


?>