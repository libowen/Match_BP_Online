<?php
/**
* FILE_NAME : public.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\public.php
* 编排过程中的重用小功能函数：
								    fun：qianfd 第一分段和中间分段
									       fun：yipei各分段的第一次配（先判断是否有上分段余项）
									       fun：erpei非最后一分段有余量>1时，拆到余<2或本分段完
									           Fun：chai逐一向上拆对配对，也逐一得到方案
									fun：zuihoufd最后一分段
									     fun：erpei2最后一分段有余量>0时，一直拆到无余！！
下面是参考流程，不要删：							     
    fun：qianfd 第一分段和中间分段
	       fun：yipei各分段的第一次配（先判断是否有上分段余项）
	           余项<2:
	           余项>=2: fun：erpei上拆配对，非最后一分段yipei有余量>1时
                            余项<2:
	                        余项>=2:fun：chai逐一向上拆对配对，也逐一得到方案；拆到余<2或本分段完
	                                    某方案的余项<2:马上跳出，
	                                    本分段完，余项>=2：获取所有方案，进行比较，取最佳方案。
 	                                                     当最佳方案还是余项>1，可以考虑进行本分段的从下往上配到特殊号？
 	                                                               还是余项>1，穷举法进行匹配！？项数小于一定数才进行？？
	fun：zuihoufd 最后一分段
	     同上fun：yipei各分段的第一次配（先判断是否有上分段余项）
	           余项<2:
	           余项>=2: fun：erpei2最后一分段有余量>0时，一直拆到无余或拆完最后一分段
                        余项<2:
	                    余项>=2:继续往上分段拆，直到无余？本分段重新从下往上配？
	                           还是余项>1，穷举法进行匹配！？								
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Mon Feb 01 16:52:27 CST 2010
*/

/**
* 增加域名验证功能，防止意外外链
* /
echo '';

/**
* 功能：第二至倒数第四轮 和 最后三轮编排的功用部分
* 参数：$chengyuan,$saizhi=1
* 返回：$taicis 数组
*/
function bp2330($chengyuan,$saizhi=1){
   	      $fd=fenzupaixu($chengyuan,1);
   	      $taicis=array();
   	      $yus=array();
   	      $fanhui=array();
/*$lingwai=array();      
foreach ($fd as $key5=> $value5) {
   	 $lingwai[0]=array_hebing($lingwai[0],$value5[0]);    		
   	 $lingwai[1]=array_hebing($lingwai[1],$value5[1]);    		
   	      		}   	      		
var_export($lingwai);exit;*/

   	      foreach ($fd as $key => $value) {
//   	      	$benfen=(isset($value[0][0]['xs_zongfen'])?$value[0][0]['xs_zongfen']:$value[1][0]['xs_zongfen']);//或取本分段的本来积分
			$linshi=isset($value[0][count($value[0])-1]['xs_zongfen'])?$value[0][count($value[0])-1]['xs_zongfen']:99999;
			$benfen=isset($value[1][count($value[1])-1]['xs_zongfen'])?$value[1][count($value[1])-1]['xs_zongfen']:99999;
			$benfen=($linshi<$benfen)?$linshi:$benfen;      //取本段的最小的积分；有可能有几个不同分数在一起，兼容了新版的模式			
//   	    echo '<br>每个分数段：'.$benfen;if ($benfen==0) {print_r($value);   	    }
   	      	$fanhui=yipei($value,$yus,$benfen);
   	      	$peiduis=$fanhui[0];
//echo '第',$benfen,'分段的yipei编排:';
//print_r($fanhui[0]);
   	      	if ($key==count($fd)-1) {//最后一个分段（由于要考虑单数个选手的编排，要引入空号）
   	      		//而且空号必须对最低分者，多个低分者对过空号（序号0）的不能再对，
   	      		    $taicis=array_hebing($taicis,$peiduis);	
  	      		    $GLOBALS['g_mofenduan']=1;
  	      		    if ((!isset($GLOBALS['bsinfo']['bs_lunkongmoshi']))||(!$GLOBALS['bsinfo']['bs_lunkongmoshi'])) { //默认模式是轮空过不能再轮空
   	      		    	$GLOBALS['g_lunkongfen']=lunkongfen($fd); //没有轮空过的最低分选手的积分值，即可以轮空的选手的积分
   	      		    	//print_r($GLOBALS['g_zuidiwei']);
  	      		    } else {
  	      		    	$GLOBALS['g_zuidishao']=zuidishao($value); //最低分轮空次数最少的选手的集合，数组
  	      		    }
  	      		    
		   	      		$fanhui=erpei($fanhui[1],$taicis,$benfen,1);  //最后一分段可以允许只剩余一个！
		   	      		//本次操作所配得的配对数组$fanhui[0] [0]/[1]，$fanhui[1]剩余项数组；$fanhui[2]剩余个数；$fanhui[3]=向上拆对数
		   	      		$taicis=array_hebing(array_slice($taicis,0,(count($taicis)-$fanhui[3])),$fanhui[0]);
		   	      		//兼容编排奇数个选手，剩余的一个将对空号
                        if ($fanhui[2]) {
                        	$konghao=array('xs_xuhao'=>'0','xs_name'=>'空号','xs_zongfen'=>'0');//补了空号后，housanlun的检查是否有影响？？！
                        	$fanhui[1][0][0]?$linshi=$fanhui[1][0][0]:'';
                        	$fanhui[1][1][0]?$linshi=$fanhui[1][1][0]:'';
                        	$peiduis=array();
                        	if ($linshi['xs_xianshu']<0) {//也许还要注意下连三的判断
                        		$peiduis[0][0]=$linshi;
                        		$peiduis[0][1]=$konghao;
                        	} else {
                        		$peiduis[0][0]=$konghao;
                        		$peiduis[0][1]=$linshi;
                        	}
                            $taicis=array_hebing($taicis,$peiduis);
                        }
   	      	}else{
		   	      	if ((count($fanhui[1][0])+count($fanhui[1][1]))>1) {
		   	      		$fanhui=erpei($fanhui[1],$fanhui[0],$benfen,0);
		   	      		//本次操作所配得的配对数组$fanhui[0][第几对] [0]/[1]，剩余项数组$fanhui[1] [0]/[1] [第几项] ，$fanhui[2]=剩余项个数，$fanhui[3]=上拆对数]
//echo '第',$benfen,'分段的erpei编排:';
//print_r($fanhui[0]);
		   	      		$weichais=array_slice($peiduis,0,(count($peiduis)-$fanhui[3]));//没拆到得本分段已配的对
		   	      		$peiduis=array_hebing($weichais,$fanhui[0]);
		   	      	}
	   	      		$yus=$fanhui[1]; //可能为空数组
	   	      		$taicis=array_hebing($taicis,$peiduis);
   	      	}
   	      } 
   	      return $taicis;
}


/**
* 功能：编排后的taicis整理排序，再次检测和按条件（一般，非考虑高分优先）赋予先后手【兼容 空号 】
* 参数：$taicis编排后bp2330得到的配对数组；$housanlun表示是否属于housanlun的编排，根据$GLOBALS['bsinfo']['bs_chafengaoping']优先平衡高分的先后手
* 返回：重新整理后的taicis
*/
function ZLtaicis($taicis,$housanlun=0) {
          $jifen1=array();
   	      $jifen2=array();
   	      $keys=array();
   	      foreach ($taicis as $key => $value) {
	   	      	if ($value[0]['xs_zongfen']>$value[1]['xs_zongfen']) {
		   	      	if ($value[1]['xs_zongfen']) {
						$jifen1[]=$value[0]['xs_zongfen'];
		   	      		$jifen2[]=$value[1]['xs_zongfen'];
					} else {  //说明[1]是0，即空号；轮空的必须在最后一桌
						$jifen1[]=-1;
		   	      		$jifen2[]=-1;
					}
	   	      	}else{
	   	      		if ($value[0]['xs_zongfen']) {
			   	      	$jifen1[]=$value[1]['xs_zongfen'];
			   	      	$jifen2[]=$value[0]['xs_zongfen'];
	   	      		} else {  //说明[1]是0，即空号；轮空的必须在最后一桌
	   	      			$jifen1[]=-1;
		   	      		$jifen2[]=-1;
	   	      		}
	   	      	}
	   	      	$keys[]=$key;
	   	      	if (isset($value[0]['xs_xianshu'])&&isset($value[1]['xs_xianshu'])) {   //兼容了 空号
		   	      	$zt=1;  // 1为正常模式；0为特殊模式且不进行正常模式
	   	      		if ($housanlun) {//housanlun的编排
		   	      	    	if ($GLOBALS['bsinfo']['bs_chafengaoping']) {//它为0时，不考虑；不为0时，才算计chafengaoping
				   	      	    	if (abs($value[0]['xs_zongfen']-$value[1]['xs_zongfen'])>=$GLOBALS['bsinfo']['bs_chafengaoping']) {//true；优先符合条件的高分项先后手
					   	      	    	   $zt=0;
				   	      	    		   for ($i=0;$i<2;$i++){
					   	      	    			if ($value[$i]['xs_zongfen']-$value[abs($i-1)]['xs_zongfen']>=$GLOBALS['bsinfo']['bs_chafengaoping']) {
					   	      	    				//还要看转换后是否有连三或多三情况出现，如果出现则不调换（不连三不一定不多三）
					   	      	    				if ($value[$i]['xs_xianshu']>0) {
					   	      	    					if ($GLOBALS['bsinfo']['bs_Jliansan']) {//是否禁止出现连三。有可能左右都是连三的呢？??不可能
						   	      	    					if ($value[abs($i-1)]['xs_xianshu']-round($value[abs($i-1)]['xs_xianshu']/100)*100+1<3
						   	      	    					&&$value[$i]['xs_xianshu']-round($value[$i]['xs_xianshu']/100)*100-1>-3 ) {
							   	      	    					$taicis[$key][0]=$value[abs($i-1)];
							   	      	    					$taicis[$key][1]=$value[$i];	
						   	      	    					}	
					   	      	    					}
					   	      	    					if ($GLOBALS['bsinfo']['bs_Jduosan']) {//是否禁止出现多三；
					   	      	    						if (round($value[abs($i-1)]['xs_xianshu']/100)+1<3
						   	      	    					&&round($value[$i]['xs_xianshu']/100)-1>-3) {//默认禁止出现多三，目前不能选择
							   	      	    					$taicis[$key][0]=$value[abs($i-1)];
							   	      	    					$taicis[$key][1]=$value[$i];	
						   	      	    					}	
					   	      	    					}
					   	      	    				}else{
					   	      	    					if ($GLOBALS['bsinfo']['bs_Jliansan']) {//是否禁止出现连三
						   	      	    					if ($value[$i]['xs_xianshu']-round($value[$i]['xs_xianshu']/100)*100+1<3
						   	      	    					&&$value[abs($i-1)]['xs_xianshu']-round($value[abs($i-1)]['xs_xianshu']/100)*100-1>-3 ) {
							   	      	    					$taicis[$key][1]=$value[abs($i-1)];
							   	      	    					$taicis[$key][0]=$value[$i];	
						   	      	    					}
					   	      	    					}
					   	      	    					if ($GLOBALS['bsinfo']['bs_Jduosan']) {//是否禁止出现多三；
					   	      	    						if (round($value[$i]['xs_xianshu']/100)+1<3
						   	      	    					&&round($value[abs($i-1)]['xs_xianshu']/100)-1>-3) {
							   	      	    					$taicis[$key][1]=$value[abs($i-1)];
							   	      	    					$taicis[$key][0]=$value[$i];	
						   	      	    					}
					   	      	    					}
					   	      	    				}
					   	      	    			}
					   	      	    	   }
						   	      	}
		   	      	    	}
	   	      	      }else{	//非housanlun的编排
	   	      	    	//直接
	   	      	      }
		   	      	  if ($zt) {
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
			   	      	    		
			   	      	    		//两者的先后手序列相同时；先后走相等的先后方式：【①取相遇者两号相加之和，奇数小号先走，偶数大号先走】【②单数轮次小号先走，双数轮次大号先走】两种方式可选择其中一种。默认第二种
			   	      	    		if ($GLOBALS['bsinfo']['bs_tongxianhou']==1) {	//①取相遇者两号相加之和，奇数小号先走，偶数大号先走
					   	      	    	$xuhaohe=$value[0]['xs_xuhao']+$value[1]['xs_xuhao'];//序号和
					   	      	    	$linshi=$xuhaohe%2;
			   	      	    		} else {	 //②单数轮次小号先走，双数轮次大号先走;包括其余情况
			   	      	    			//单轮小号先，双轮大号先
					   	      	    	$lunci=substr_count($taicis[0][0]['xs_towhos'],',')/2+1;//正在编排的轮次
					   	      	    	$linshi=$lunci%2;
			   	      	    		}
				   	      	    	if ($linshi) {	//序号和 或 轮次 为奇数，小号先
				   	      	    		if ($value[0]['xs_xuhao']>$value[1]['xs_xuhao']) {
						   	      	    	$taicis[$key][0]=$value[1];
						   	      	    	$taicis[$key][1]=$value[0];
				   	      	    		}
				   	      	    	}else{	//序号和 或 轮次 为偶数，大号先
				   	      	    		if ($value[0]['xs_xuhao']<$value[1]['xs_xuhao']) {
						   	      	    	$taicis[$key][0]=$value[1];
						   	      	    	$taicis[$key][1]=$value[0];
				   	      	    		}
				   	      	    	}	
			   	      	    	}
			   	      	    }
		   	      	  } 		
	   	      	}else{//空号的一台，为保证，再次进行检测校正
	   	      		if ((isset($value[0]['xs_xianshu'])&&$value[0]['xs_xianshu']>0)
	   	      		||(isset($value[1]['xs_xianshu'])&&$value[1]['xs_xianshu']<0)) {
	   	      				$taicis[$key][0]=$value[1];
		   	      	    	$taicis[$key][1]=$value[0];
	   	      		}
	   	      	}
   	      }
   	      array_multisort($jifen1,SORT_DESC,$jifen2,SORT_DESC,$keys,SORT_ASC,$taicis);
   	      return $taicis;
}

/**
* 功能：异行配对，原原或拆拆或余原或拆原 的异行配对，所以$yus可为空
* 参数：$yuans 原，$yus 余原的余、拆原的拆；
* 返回：异行配对后 $fanhui[0]=配对数组，剩余的原项数组$fanhui[1]，剩余的$yus数组$fanhui[2]；[0]=要先行数组，[1]=要后行数组；
*/
function yihang($yuans,$yus=array()){
	$duishu=0;
	$peiduis=array();
    if ($yus[0]||$yus[1]) {//$yus不为空，属于余原或拆原 的异行配对
       for ($h1=0;$h1<2;$h1++) {
      	   $h1?$linshi=0:$linshi=1;
		   $duoshuzu=abs(1-$linshi);
		   for($j=0;$j<count($yus[$linshi]);$j++){
				  if(!$yus[$linshi][$j]['xs_zt']){//本身未使用过；
					   for($h=0;$h<count($yuans[$duoshuzu]);$h++){
							  if(!$yuans[$duoshuzu][$h]['xs_zt']){//对方未使用过；
							  	  //按bsinfo的设置，选择判断Jliansan、TTbuyu、SXtiao
							  	  if (!peiduipan($yus[$linshi][$j],$yuans[$duoshuzu][$h],$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan'])) {
							  	  	 continue;
							  	  }
								  //配对条件：本身未使用过；对方未使用过；两者未相遇过；对后不出现多3的情况
									  if(!strstr($yus[$linshi][$j]['xs_towhos'],','.$yuans[$duoshuzu][$h]['xs_xuhao'].',')){
										   //两者未相对过的，由于两者分别在两个小组里的，不需多3的判断	
											$peiduis[$duishu][$linshi]=$yus[$linshi][$j];
											$peiduis[$duishu][$duoshuzu]=$yuans[$duoshuzu][$h];
											 
											$yus[$linshi][$j]['xs_zt']=1;
											$yuans[$duoshuzu][$h]['xs_zt']=1;
											$duishu++;
											break;
									  }
							   }
					   }
				 }
		   }
      }
   }else{
   	//属于原原或拆拆 的异行配对
	      //$yus都同分则判断$yus 的多数行和少数行，少数行去抽多数组
      	   if(count($yuans[0])!=count($yuans[1])){	 
			  count($yuans[0])<count($yuans[1])?$linshi=0:$linshi=1;//先选出少数组 linshi  ；多数组 duoshuzu
		   }else{
		       //如果相等的两组，单轮小号，双轮大号
			   if($yuans[0][0]['xs_xuhao']<$yuans[1][0]['xs_xuhao']){
				(substr_count($yuans[0][0]['xs_fenshus'],',')/2+1)%2?$linshi=0:$linshi=1;
			   }else{
				(substr_count($yuans[0][0]['xs_fenshus'],',')/2+1)%2?$linshi=1:$linshi=0;
			   }
		   }
	   	   $duoshuzu=abs(1-$linshi);
	   		for ($j=0;$j<count($yuans[$linshi]);$j++){//第一次就不成立，则马上跳出
	   			if (!$yuans[$linshi][$j]['xs_zt']) {
	   				for ($h=0;$h<count($yuans[$duoshuzu]);$h++){
	   					if (!$yuans[$duoshuzu][$h]['xs_zt']) {
							   if(!strstr($yuans[$linshi][$j]['xs_towhos'],','.$yuans[$duoshuzu][$h]['xs_xuhao'].',')){
							  	//按bsinfo的设置，选择判断Jliansan、TTbuyu、SXtiao
							  	  if (!peiduipan($yuans[$linshi][$j],$yuans[$duoshuzu][$h],$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan'])) {
							  	  	 continue;
							  	  }
							   	//两者未相对过的，由于两者分别在两个小组里的，所以直接录入$peiduis数组中，而不需多3的判断了	
										$peiduis[$duishu][$linshi]=$yuans[$linshi][$j];
									    $peiduis[$duishu][$duoshuzu]=$yuans[$duoshuzu][$h];
										
										$yuans[$linshi][$j]['xs_zt']=1;
										$yuans[$duoshuzu][$h]['xs_zt']=1;
										$duishu++;
										break;
							  }
	   					}
	   				}
	   			}
	   		}
   }
   //计算并返回各数组:$fanhui[0]=配对数组，剩余的原项数组$fanhui[1]，剩余的$yus数组$fanhui[2]；[0]=要先行数组，[1]=要后行数组；
   $fanhui=array();
   $fanhui[0]=$peiduis;
   $fanhui[1][0]=array();
   $fanhui[1][1]=array();
   $fanhui[2][0]=array();
   $fanhui[2][1]=array();
   for($i=0;$i<2;$i++){
	   if($yus[$i]){
		   foreach($yus[$i] as $key => $value){
				if(!$value['xs_zt']){
				  $fanhui[2][$i][]=$value;			
				} 
		   }
	   }
	   if($yuans[$i]){
		   foreach($yuans[$i] as $key => $value){
				if(!$value['xs_zt']){
				  $fanhui[1][$i][]=$value;			
				} 
		   }
	   }
   }
   return $fanhui;
}

/**
* 功能：同行的配对，原原或拆拆或余原或拆原 的异行配对，所以$yus可为空
* 参数：$yuans 原，$yus 余原的余、拆原的拆；
* 返回：同行配对后 $fanhui[0]=配对数组，剩余的项数组$fanhui[1]其中$fanhui[1][0]=要先行数组，$fanhui[1][1]=要后行数组；
*/
function tonghang($yuans,$yus=array()) {
   $duishu=0;
   if ($yus[0]||$yus[1]) {
   	//$yus[0]或$yus[1] 不为空，属于余原或拆原 的同行配对
	   	for($h1=0;$h1<2;$h1++) {
	   		$h1?$linshi=0:$linshi=1;
////////////注意：$yusns[$linshi]要为未定义才行的，空值也算一个的！！！！！！
	   		for ($j=0;$j<count($yus[$linshi]);$j++){//第一次就不成立，则马上跳出
	   			if (!$yus[$linshi][$j]['xs_zt']) {
	   				for ($h=0;$h<count($yuans[$linshi]);$h++){     
	   					if (!$yuans[$linshi][$h]['xs_zt']) {
							   if(!strstr($yus[$linshi][$j]['xs_towhos'],','.$yuans[$linshi][$h]['xs_xuhao'].',')){
							   		//按bsinfo的设置，选择判断Jliansan、TTbuyu、SXtiao
							  	  //if (!peiduipan($yus[$linshi][$j],$yuans[$linshi][$h],$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan'])) {
							  	  if (!peiduipan($yus[$linshi][$j],$yuans[$linshi][$h],$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan'])) {
							  	  	 continue;
							  	  }
							  	  //两者未相对过的，由于两者在同行里的，需进行多三先或多三后的判断	
//								     if(abs($yus[$linshi][$j]['xs_xianshu'])<105||abs($yuans[$linshi][$h]['xs_xianshu'])<105) {

											if($yus[$linshi][$j]['xs_xianshu']==$yuans[$linshi][$h]['xs_xianshu']) {
											//先后手情况相同，是否优先配平高分的（后三轮考虑），目前考虑单轮小号先、双轮大号先
												   if((substr_count($yus[$linshi][$j]['xs_fenshus'],',')/2+1)%2){
													 if($yus[$linshi][$j]['xs_xuhao']<$yuans[$linshi][$h]['xs_xuhao']){
													   $peiduis[$duishu][0]=$yus[$linshi][$j];
													   $peiduis[$duishu][1]=$yuans[$linshi][$h];
													 }else{
													   $peiduis[$duishu][0]=$yus[$linshi][$j];
													   $peiduis[$duishu][1]=$yuans[$linshi][$h];
													 }
												   }else{
													 if($yus[$linshi][$j]['xs_xuhao']>$yuans[$linshi][$h]['xs_xuhao']){
													   $peiduis[$duishu][0]=$yus[$linshi][$j];
													   $peiduis[$duishu][1]=$yuans[$linshi][$h];
													 }else{
													   $peiduis[$duishu][0]=$yus[$linshi][$j];
													   $peiduis[$duishu][1]=$yuans[$linshi][$h];
													 }
												   }
												  ////
											  
											}else{
											  $peiduis[$duishu][0]=$yus[$linshi][$j];
											  $peiduis[$duishu][1]=$yuans[$linshi][$h];
											}
											$yus[$linshi][$j]['xs_zt']=1;
											$yuans[$linshi][$h]['xs_zt']=1;
											$duishu++;
											break;
//									}
							  }
	   					}
	   				}
	   			}
	   		}
	   	}
   } else {
   	//属于原原或拆拆 的同行配对
	   	for($h1=0;$h1<2;$h1++){
	   		$h1?$linshi=0:$linshi=1;
////////////注意：$yusns[$linshi]要为未定义才行的，空值也算一个的！！！！！！
	   		for ($j=0;$j<count($yuans[$linshi]);$j++){//第一次就不成立，则马上跳出
	   			if (!$yuans[$linshi][$j]['xs_zt']) {
				    //for ($h=count($yuans[$linshi]);$h>$j;$h--){     //首尾相配
	   				for ($h=$j+1;$h<count($yuans[$linshi]);$h++){     //临近相配
	   					if (!$yuans[$linshi][$h]['xs_zt']) {
							       if(!strstr($yuans[$linshi][$j]['xs_towhos'],','.$yuans[$linshi][$h]['xs_xuhao'].',')){
								  	 //按bsinfo的设置，选择判断Jliansan、TTbuyu、SXtiao
								  	  if (!peiduipan($yuans[$linshi][$j],$yuans[$linshi][$h],$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan'])) {
								  	  	 continue;
								  	  }
							       	//两者未相对过的，由于两者在同行里的，需进行多三先或多三后的判断	
//										 if(abs($yuans[$linshi][$j]['xs_xianshu'])<105||abs($yuans[$linshi][$h]['xs_xianshu'])<105){
											if($linshi) {
												//要后的组
											  $peiduis[$duishu][0]=$yuans[$linshi][$h];
											  $peiduis[$duishu][1]=$yuans[$linshi][$j];
											} else {
												//要先的组
											  $peiduis[$duishu][0]=$yuans[$linshi][$j];
											  $peiduis[$duishu][1]=$yuans[$linshi][$h];
											}
											$yuans[$linshi][$j]['xs_zt']=1;
											$yuans[$linshi][$h]['xs_zt']=1;
											$duishu++;
											break;
//								    }
							  }
	   					}
	   				}
	   			}
	   		}
	   	}
   }
   //返回的值：$fanhui[0]=配对数组，剩余的项数组$fanhui[1]其中$fanhui[1][0]=要先行数组，$fanhui[1][1]=要后行数组；
   $fanhui=array();
   $fanhui[0]=$peiduis;
   $fanhui[1][0]=array();
   $fanhui[1][1]=array();//同行配后，如有高分项都作平等处理了（只是余原同行配后可能有前余项的剩余，影响再异行配前进行少行的判断）
   for($i=0;$i<2;$i++){
	   if($yus[$i][0]){
		   foreach($yus[$i] as $key => $value){
				if(!$value['xs_zt']){
				  $fanhui[1][$i][]=$value;			
				} 
		   }
	   }
	   if($yuans[$i][0]){
		   foreach($yuans[$i] as $key => $value){
				if(!$value['xs_zt']){
				  $fanhui[1][$i][]=$value;			
				} 
		   }
	   }
   }
   return $fanhui;
}

/**
* 功能：上一操作后的余项和正要配对的原项或拆项的配对
* 参数：$yus ;$yuans=fd[目前分段] ;
* 返回：本次操作的 配对数组$fanhui[0]，剩下的项（本分段包括高分项的所有未配项）数组$fanhui[1]，
*/
function yuyuanpei($yuans,$yus){
   //余原 异行配对
   $fanhui=yihang($yuans,$yus);
   $peiduis=$fanhui[0];
   if ((count($fanhui[1][0])&&count($fanhui[2][0]))||(count($fanhui[1][1])&&count($fanhui[2][1]))) {
       //余原 同行配对
      $fanhui=tonghang($fanhui[1],$fanhui[2]);
      $peiduis=array_hebing($peiduis,$fanhui[0]);      	
   }else{
     	if ($fanhui[2][0]) {
   	   	$fanhui[1][0]=array_hebing($fanhui[2][0],$fanhui[1][0]);	
   	    }  
     	if ($fanhui[2][1]) {
   	    $fanhui[1][1]=array_hebing($fanhui[2][1],$fanhui[1][1]);
     	}
   }
   $fanhui[0]=$peiduis;
   //$fanhui[1]=$fanhui[1];
   return $fanhui;
}

/**
* 功能：yipei时原分段的项，或erpei拆配时的yipei拆项，内部的配对：异行、同行
* 参数：$yuans=fd[目前分段] 或yuyuanpei后的所有剩余项$fanhui[1]（注意：可能会有高分项）
* 返回：本次操作的配对数组$fanhui[0] [0]/[1]和剩下的项数组$fanhui[1] [0]/[1]
*/
function yuanyuanpei($yuans){
	$linshi=yihang($yuans);
//		$yuanshengshu=count($linshi[1][0])+count($linshi[1][1]); //值计算原项的剩余个数
	$shengshu=count($linshi[2][0])+count($linshi[2][1])+count($linshi[1][0])+count($linshi[1][1]);
	if ($shengshu>5) {  //旧版的，多了一次tonghang()
	     //这种是使用同行配对的旧模式；这里只做保留！ 
	    //异行配对
	    $peiduis=$linshi[0];
	    //同行配对
	    $fanhui=tonghang($linshi[1]);
	    $fanhui[0]=array_hebing($peiduis,$fanhui[0]);
	} else { //！！！！！虽然可以达到理想配对，但万一出现8、9个的穷举就是性能无法承受的！！！尽量控制在5/7个以下
	    /* 计划不使用同行配对，直接使用qiongju */
	    // 异行配对
	    $fanhui[0]=$linshi[0];
	    $fanhui[1]=array();
	    $fanhui[1][0]=array_hebing($linshi[2][0],$linshi[1][0]);
	    $fanhui[1][1]=array_hebing($linshi[2][1],$linshi[1][1]);
	    //不使用同行配对，直接跳到使用 qiongju 了
	}
    return $fanhui;
}

/**
* 功能：erpei时余拆配对，拆x+1对时获得的一个方案！！！可能造成高分剩余项的位置变动，需要再重新排序！！！
* 参数：$chais,$yus,$benfen
* 返回：$fangan数组,一般和while配合生成（X 为方案的编号序号）$fangans[X][0]的值为本方案的重新配对数组；$fangans[X][1]本方案的剩余项数组；$fangans[X][2]为剩余项比较标准值yuzhi；上拆数在外部计算
*/
function fangan($chais,$yus,$benfen){
	/*
	   //余拆配对
	   $fanhui=yuyuanpei($chais,$yus);
	   $peiduis=$fanhui[0];
	   //拆拆配对
	   $fanhui=yuanyuanpei($fanhui[1]);
	   $fanhui[0]=array_hebing($peiduis,$fanhui[0]);
	   //$fanhui[1]=$fanhui[1];
	   //$fanhui[2]=count($fanhui[1][0])+count($fanhui[1][1]);
   */
   $fanhui[2]=yuzhi($fanhui[1],$benfen);  //剩余项比较标准值
	if (!$GLOBALS['g_buqiongju']) {  //判断是否设定不进行此项qiongju
		   $chengyuan[0]=array_hebing($chais[0],$yus[0]);  
		   $chengyuan[1]=array_hebing($chais[1],$yus[1]);  
		/*if ($benfen==9||$benfen==10||$benfen==7) {
			print_r($chengyuan,true);
			var_export($chengyuan);
			echo '<br>',$benfen,'<br>';
			exit;
		}*/
//var_dump($chengyuan);
		   $qiongju=qiongju($chengyuan,array(),$benfen,$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan']);//增加穷举配对方法，fangan里的拆余配只传递一个参数
//		   if ($qiongju[2]<$fanhui[2]) {
		   	 $fanhui[0]=$qiongju[0];
		   	 //$fanhui[1]=$qiongju[1];
				   	 for ($j=0;$j<2;$j++){
				   	 	if ($chais[$j]) {
				   	 	foreach ($chais[$j] as $key => $value) {//$chais不能有空数组或[0]或[1]可能为空时也需判断
				   	 		$a=1;
				   	 		foreach ($qiongju[1] as $ke => $val) {
					   	 		if ($value['xs_xuhao']==$val) {
					   	 			$a=0;
					   	 			break 1;
					   	 		}
				   	 		}
				   	 		if ($a) {
				   	 			$shengyu[$j][]=$value;
				   	 		}
				   	 	}	
				   	 	}else{
				   	 		$shengyu[$j]=array();//保证[0]和[1]都定义了数组
				   	 	}
				   	 	if ($yus[$j]) {
					   	 	foreach ($yus[$j] as $key => $value) {
					   	 		$a=1;
					   	 		foreach ($qiongju[1] as $ke => $val) {
						   	 		if ($value['xs_xuhao']==$val) {
						   	 			$a=0;
						   	 			break 1;
						   	 		}
					   	 		}
					   	 		if ($a) {
					   	 			$shengyu[$j][]=$value;
					   	 		}
					   	 	}
				   	 	}
				   	 }
		   	 $fanhui[1]=$shengyu;
		   	 $fanhui[2]=$qiongju[2];
//		   }
	} else {
		   //余拆配对
		   $fanhui=yuyuanpei($chais,$yus);
		   $peiduis=$fanhui[0];
		   //拆拆配对
		   $fanhui=yuanyuanpei($fanhui[1]);
		   $fanhui[0]=array_hebing($peiduis,$fanhui[0]);
		   $fanhui[1]=$fanhui[1];
		   $fanhui[2]=yuzhi($fanhui[1],$benfen);  //剩余项比较标准值
//		   $fanhui[2]=count($fanhui[1][0])+count($fanhui[1][1]);
	}
   //！！！可能造成高分剩余项的位置变动，需要再重新排序！！！$fanhui[1]
   return $fanhui;
}

/**
* 功能：非末分段yipei后有余量>0时，逐上拆到余项<2或拆完本分段
* 参数：本分段中yipei后已经配好的$peiduis对阵（可以为空）；余项$yus；（注意：均是分成2行的[0] or [1]）；$benfen 此分段的本来积分；$mofenduan判断是否是最后一分段的erpei
* 返回：本次操作所配得的配对数组$fanhui[0][第几对] [0]/[1]，剩余项数组$fanhui[1] [0]/[1] [第几项] ，$fanhui[2]=剩余项个数，$fanhui[3]=上拆对数
*/
function erpei($yus,$peiduis,$benfen,$mofenduan=0) {
/*if ($benfen==9) {
	//print_r($chengyuan,true);
	var_export($yus);
	echo 'peiduis=';
	var_export($peiduis);
	echo '<br>erpei[',$benfen,']<br>';
}*/
   if ($peiduis) {
   	     //可以往上拆
   	     $chais[0]=array();
   	     $chais[1]=array();
   	     $i=0;
   	     while (isset($peiduis[0])) {
   	     	$chai=array_pop($peiduis);//chai不一定就是一个要先 一个要后，而是看情况的
   	     	foreach ($chai as $key => $value) {
   	     		$chachai[0]=$value;
   	     		if ($value['xs_xianshu']<0) {
	   	     		$chais[0]=array_hebing($chachai,$chais[0]);  //！！！万一$chais[0]为空数组呢！！
	   	     	}else{
	   	     		$chais[1]=array_hebing($chachai,$chais[1]);  //！！！万一$chais[0]为空数组呢！！？
	   	     	}
   	     	}
   	     	////！！！！原来按xianshu排列的顺序可能有所变化了,是否考虑？？！！
   	        $fangans[$i]=fangan($chais,$yus,$benfen);  //返回：$fangans数组,X 为方案的编号序号；$fangans[X][0]的值为本方案的重新配对数组；$fangans[X][1]本方案的剩余项数组；$fangans[X][2]为剩余项比较标准值yuzhi；$fangans[X][3]为所拆对数量值（下行代码来处理）
   	        $fangans[$i][3]=$i+1;                                         //上拆的对数
   	 
   	        if ((!isset($GLOBALS['bsinfo']['bs_lunkongmoshi']))||(!$GLOBALS['bsinfo']['bs_lunkongmoshi'])) { //默认模式是轮空过不能再轮空
   	        	if ($mofenduan) {
//print_r($fangans[$i][1]);
//echo $fangans[$i][1][1][0]['xs_zongfen'],"<br>",$GLOBALS['g_lunkongfen'],"<hr>";
   	        		if ( ( count($fangans[$i][1][0]) + count($fangans[$i][1][1]) )==1) {    //剩余只一项的，还要判断是否是没对过空号的最低分项
   	        			 //剩余没轮空过的最低分项，因为穷举已经确保剩余的项必是未轮空的项
   	        			 if ($fangans[$i][1][0][0]['xs_zongfen']==$GLOBALS['g_lunkongfen']
   	        			 &&strpos($fangans[$i][1][0][0]['xs_towhos'],',0,')===false) {
		   	        			return $fangans[$i];    //结束这个函数，并返回值
		   	        	 }
		   	        	 if ($fangans[$i][1][1][0]['xs_zongfen']==$GLOBALS['g_lunkongfen']
   	        			 &&strpos($fangans[$i][1][1][0]['xs_towhos'],',0,')===false) {
		   	        			return $fangans[$i];    //结束这个函数，并返回值
		   	        	 }
   	        			//否则继续上拆穷举 	        	         
   	        		} else {
   	        			if ( ( count($fangans[$i][1][0]) + count($fangans[$i][1][1]) )<1) {
   	        				//不剩余的直接return
   	        			 return $fangans[$i];    //结束这个函数，并返回值
   	        			}
   	        			//否则继续上拆穷举
   	        		}
   	        	} else {
   	        		if ($fangans[$i][2]-floor($fangans[$i][2]/100)*100<2) { //剩余项标准比较值<2，跳出并直接赋值
   	        			return $fangans[$i];    //结束这个函数，并返回值
   	        		}
   	        	}
   	        	
   	        } else {  //轮空模式是；空号必须对最低分者，多个最低分者取轮空次数较少的，再就是 单轮小号先（固定，不能选择了），双轮大号先
	   	        //if ($fangans[$i][2]<2) {//剩余项<2，跳出并直接赋值
	 			if ($fangans[$i][2]-floor($fangans[$i][2]/100)*100<2) {//剩余项标准比较值<2，跳出并直接赋值
	   	        	//由于yuyuanpei已经穷举过了，高分项已经不影响原项剩一项的情况了
	   	        	//如果是最后一分段，还要判断是否最低分！否则继续向上拆配
	   	        	if ($mofenduan) {
	   	        		if ($fangans[$i][2]==1) {
	   	        			//空号必须对最低分者，多个低分者对过空号（序号0）的不能再对，
	   	        			   //似乎没有考虑：多个低分者对过空号（序号0）的不能再对，！！！
	   	        			//print_r($fangans[$i][1]);
		   	        		if ($fangans[$i][1][0][0]['xs_zongfen']==$benfen||$fangans[$i][1][1][0]['xs_zongfen']==$benfen) {
		   	        			return $fangans[$i];    //结束这个函数，并返回值
		   	        		}	
	   	        		}else{
	   	        			return $fangans[$i];    //结束这个函数，并返回值
	   	        		}   	        		
	   	        	} else {
		   	        	return $fangans[$i];    //结束这个函数，并返回值
	   	        	}
	   	        }
   	        }
   	        $i++;
   	     }
   	     //分拆完整个分段和没拆完两种情况
   	     if (isset($peiduis[0])) {  //未拆完的情况
   	     	/*
	   	     $shengyushu=$chaiduishu=array();
	   	     foreach ( $fangans as $val ) {
				   $shengyushu[]=$val[2];
				   $chaiduishu[]=$val[3];
			 }
			 array_multisort($shengyushu,$chaiduishu,$fangans);
			 */
   	     	//未拆完就跳出循环，应该直接取最后一个方案即可；注意$i的取值
   	     	$fangans[0]=$fangans[$i];
   	     } else {  //拆完的情况
   	     	if (isset($fangans[$i])) { //说明是直接跳出的，刚好拆完能够符合跳出循环的条件
   	     		$fangans[0]=$fangans[$i];
   	     	} else {
	   	     	 // 再进行一次全拆的穷举（考虑多三，不考虑连三的情况）
		
				 $chengyuan[0]=array_hebing($chais[0],$yus[0]);  // chengyuan的变量可能会和全局的冲突！！！！！？？
				 $chengyuan[1]=array_hebing($chais[1],$yus[1]);  //peiduis被前面的销毁了！！！所以只能使用chais
				 
				 $qiongju=qiongju($chengyuan,array(),$benfen,1,0); // 增加穷举配对方法，fangan里的拆余配只传递一个参数
				 // 因为有xianhouhe的筛选，所以可以保证是最优先后平衡；但最后一分段上拆时呢？？！
			   	 for ($j=0;$j<2;$j++) {
			   	 	if ($chengyuan[$j]) { //要使用qiongju传入的值！chengyuan已经包括yus了
			   	 	foreach ($chengyuan[$j] as $key => $value) {//$chais不能有空数组或[0]或[1]可能为空时也需判断
			   	 		$a=1;
			   	 		foreach ($qiongju[1] as $ke => $val) {
				   	 		if ($value['xs_xuhao']==$val) {
				   	 			$a=0;
				   	 			break 1;
				   	 		}
			   	 		}
			   	 		if ($a) {
			   	 			$shengyu[$j][]=$value;
			   	 		}
			   	 	}
			   	 	}else{
			   	 		$shengyu[$j]=array();//保证[0]和[1]都定义了数组
			   	 	}
			   	 }
				 $fangans[$i][0]=$qiongju[0];
			   	 $fangans[$i][1]=$shengyu; 
		   		 $fangans[$i][2]=$qiongju[2];
	   	         $fangans[$i][3]=$i;  // 不用加1了，注意
   	     
				 //对上面所有的fangans进行因素数值比较取出最佳方案
				 $shengyushu=$yuzhis=$jifenchas=$xianshuhes=$shangxiazhis=$chaiduishu=array();
		   	     foreach ( $fangans as $val ) {
					   $shengyushu[]=$val[2];
					   $yuzhis[]=yuzhi($val[1],$benfen); 											//拆完整个分段才起作用
					   $jifenchas[]=jifencha($val[0],array_hebing($val[1][0],$val[1][1]),$benfen);			//拆完整个分段才起作用
					   $xianshuhes[]=xianshuhe($val[0],array_hebing($val[1][0],$val[1][1]));		//拆完整个分段才起作用
					   $shangxiazhis[]=shangxiazhi($val[0],array_hebing($val[1][0],$val[1][1]));	//拆完整个分段才起作用
					   $chaiduishu[]=$val[3];
				 }
				 array_multisort($shengyushu,$yuzhis,$jifenchas,$xianshuhes,$shangxiazhis,$chaiduishu,$fangans);		 
   	     	}
   	     }
   	     $fanhui=$fangans[0];
   }else{
   	   /* //不能往上拆了
   	    $fanhui[0]=array();    //本次操作的配对数组
   	    $fanhui[1]=$yus;  //剩余项数组，内分[0]和[1] 先行和后行
   	    $fanhui[2]=0;     //剩余项的个数
   	    $fanhui[3]=0;     //上拆的对数*/
   	   // 直接进行穷举了；因为只有一个方案，所以也不用比较了
   	    return fangan($peiduis,$yus,$benfen);
   }
   //由于fanan()可能造成$yus的高分项等位置的意外变化，故再次排序
/*   for ($j=0;$j<2;$j++) {
   	   if (count($fanhui[1][$j])>1) {
   	   	    $jifen=array();
   	   	    $xianshu=array();
   		    foreach ($fanhui[1][$j] as $value) {
		   		$jifen[]=$value['xs_zongfen'];
		   		$xianshu[]=abs($value['xs_xianshu']);
		   	}
		   	array_multisort($jifen, SORT_DESC,$xianshu, SORT_DESC,$fanhui[1][$j]);
	   }
   }*/
   //由于fanan()可能造成$yus的高分项等位置的意外变化，故再次排序if
   if ($fanhui[1][0]||$fanhui[1][1]) {
   	  	 $fanhui[1]=fenzupaixu(array_hebing($fanhui[1][0],$fanhui[1][1]),0);
   		 $fanhui[1]=$fanhui[1][0];   //未准确地测试过，观察中！！
   }
   
   return $fanhui;
}


/**
* 功能：每个分段的第一次配对，即下调项与本分段原项间的配对
* 参数：$yuans=$fd[目前分段];$yus=上一分段的余项数组（注意：均是分成2行的[0] or [1]）；$benfen 此分段的本来积分
* 返回：本次操作的配对$fanhui[0]，余项（可能会有高分的）$fanhui[1]，
*/
function yipei($yuans,$yus,$benfen){
/*if ($benfen==9||$benfen==10||$benfen==7) {
	//print_r($chengyuan,true);
	echo '<br>',$benfen;
	var_export($yuans);
	echo '<br>';
	var_export($yus);
}*/
   if ($yus) {//有下调项
   	  $fanhui=yuyuanpei($yuans,$yus);         //余原配对，即下调项与原分段的项配对
   	  /////////////////////////////////////////////////////////
   	  if (count($fanhui[1][0])+count($fanhui[1][1])) {
	   	  //如果余项有高分项，则进行穷举配对充分配对完高分项；万一高分项又有多个层次呢
	   	  $yuzhi=yuzhi($fanhui[1],$benfen);
	   	  if ($yuzhi>=100) {
	   	  	 $qiongju=qiongju($yuans,$yus,$benfen,$GLOBALS['bsinfo']['bs_Jduosan'],$GLOBALS['bsinfo']['bs_Jliansan']);         //yipei的余原配对后剩的项还有高分项，则进行多一次穷举配对（两个参数的情况）
	   	     if ($qiongju[0][0]||$qiongju[0][1]) {
			   	  	 if (floor($qiongju[2]/100)<floor($yuzhi/100)) {//$qiongju[2]不精确，只能比较百位以上的数了
				   	     	$fanhui[0]=$qiongju[0];
				   	     	//$fanhui[1]=$qiongju[1];//由于临时改变成已配对项的xs_xuhao值数组
				   	     	if ($qiongju[1]) {
					   	     	for ($j=0;$j<2;$j++){
					   	     		if ($yus[$j]) {
								   	 	foreach ($yus[$j] as $key => $value) {
								   	 		$a=1;
								   	 		foreach ($qiongju[1] as $ke => $val) {
									   	 		if ($value['xs_xuhao']==$val) {
									   	 			$a=0;
									   	 			break 1;
									   	 		}
								   	 		}
								   	 		if ($a) {
								   	 			$shengyu[$j][]=$value;
								   	 		}
								   	 	}	
					   	     		}
					   	     		if ($yuans[$j]) {
						   	     		foreach ($yuans[$j] as $key => $value) {
								   	 		$a=1;
								   	 		foreach ($qiongju[1] as $ke => $val) {
									   	 		if ($value['xs_xuhao']==$val) {
									   	 			$a=0;
									   	 			break 1;
									   	 		}
								   	 		}
								   	 		if ($a) {
								   	 			$shengyu[$j][]=$value;
								   	 		}
								   	 	}	
					   	     		}
							   	 }
							     $fanhui[1]=$shengyu;	
				   	     	}
			   	     }	   	     	
	   	     }else{
	   	     	 //没有新的配对产生是直接排除的
	   	     }
	   	  }
   	  }
   	  /////////////////////////////////////////////////////////
/*if ($benfen==9) {
	//print_r($chengyuan,true);
	echo '<br>',$benfen;
	var_export($fanhui);
}*/
      $peiduis=$fanhui[0];                    //上次操作得到的配对数组
      $fanhui=yuanyuanpei($fanhui[1]);        //原原配对，可能会参有高分项但不影响
      $peiduis?$fanhui[0]=array_hebing($peiduis,$fanhui[0]):$fanhui[0]=$fanhui[0];/////！！！如果$fanhui[0]=''呢，没试过；如果$taicis=''呢，没试过
   }else{//无下调项
   	  $fanhui=yuanyuanpei($yuans);
   }
   return $fanhui;
}


   /**
   *功能：按分分段并分先后行：总分 顺序；
   *参数：$chengyuan【按序号排序的数组】；$fenceng 不同积分是否分层（一般fd的计算要分层，其他情况一般不用分层）
   *返回：$fd三维数组；如果不分层则是$fd[0][先行/后行][...
   */
   function fenzupaixu($chengyuan,$fenceng=1) {
   	   //$dijilun=substr_count($chengyuan[0]['xs_fenshus'],',')/2+1;//增加了选手退赛和连弃退赛功能后不再有效
   	   $dijilun=$GLOBALS['dijilun'];
   	   if (count($chengyuan)>1) {
	   	   sort($chengyuan);
	       foreach($chengyuan as $key => $val) {
		       $zongfens[$key]=$val[xs_zongfen];
			   $xianshus[$key]=abs($val[xs_xianshu]);
			   $xuhaos[$key]=$val[xs_xuhao];
			   $shangxia[$key]=$val['xs_shangxiacha'];
		   }
		   if (!$GLOBALS['bsinfo']['bs_SXtiao']) {  //不考虑上下调平衡
			   if ($dijilun%2) {  //单轮次 小号在前
			      array_multisort($zongfens,SORT_DESC ,$xianshus,SORT_DESC ,$xuhaos,$chengyuan);
			   } else {  //双数轮次 大号在前
			      array_multisort($zongfens,SORT_DESC ,$xianshus,SORT_DESC ,$xuhaos,SORT_DESC ,$chengyuan);
			   }	   
		   } else {  //考虑上下调
		       if ($dijilun%2) {  //单轮次 小号在前
			      array_multisort($zongfens,SORT_DESC ,$xianshus,SORT_DESC ,$shangxia,$xuhaos,$chengyuan);
			   } else {  //双数轮次 大号在前
			      array_multisort($zongfens,SORT_DESC ,$xianshus,SORT_DESC ,$shangxia,$xuhaos,SORT_DESC ,$chengyuan);
			   }	
		   }
   	   } elseif (!$chengyuan) {
   	   	  echo '一个值没有！fenzupaixu函数内的$chengyuan <br>';
   	   	  print_r($chengyuan);
   	   	  exit();
   	   } else {
   	   	  //一个得不用重排
   	   }
	   
	   //截取同分段，并分要先、要后行组，然后分别计算个数来确定主客行组（如果有一组无数据，则
	   //一般fd的计算要分层，其他情况一般不用分层
	   if ($fenceng) {
	   	   $fd=array();
	   	   $k=0;
		   for ($i=0;$i<count($chengyuan);$i++) { 
			   $chengyuan[$i]['xs_xianshu']>0?$j=1:$j=0;	//大于0的为要后的组，小于0的是要先的组
			   if($i-1<0||$chengyuan[$i]['xs_zongfen']==$chengyuan[$i-1]['xs_zongfen']) {	//第一个chengyuan时必定为真，
			      $fd[$k][$j][]=$chengyuan[$i];
			   } else {
			      $k++;
			      $fd[$k][$j][]=$chengyuan[$i];
			   }
		   }
	   } else {
	   	   $fd=array();
		   for ($i=0;$i<count($chengyuan);$i++) { 
			   $chengyuan[$i]['xs_xianshu']>0?$j=1:$j=0;	//大于0的为要后的组，小于0的是要先的组
			   $fd[0][$j][]=$chengyuan[$i];
		   }
	   }
     return $fd;
   }
   
	/**
	* 功能：合并两个数组，如参数不为数组则赋值空数组后再合并
	* 参数：$a,$b 数组或其他类型的数据
	* 返回：两个数据合并后的新数组，只一个时是直接赋值的！
	*/
	function array_hebing($a,$b){
		   is_array($a)?$a=$a:$a=array();
		   is_array($b)?$b=$b:$b=array();
		   return array_merge($a,$b);   //如果键名有重复，该键的键值为最后一个键名对应的值（后面的覆盖前面的）。如果数组是数字索引的，则键名会以连续方式重新索引。
	}

	/**
	* 功能：使用穷举法进行配对，两个参数时为yipei的余原配对，一个参数为拆余配对时的。！！！！！！还需要考虑多三先或后的情况！！！！！
	* 参数：$yuans 只一个参数则为fangan里的拆余配对时的, $yus 默认=array()，两个参数时则为yipei的余原配对；$Jduosan 是否禁止多三先后,$Jliansan 是否禁止连三先后
	* 返回：一个最佳配对方案，$fanhui[0]=配对数组，[1]=已配对的项的xs_xuhao值数组！！！，[2]=剩余项数目的比较标准值（考虑高分项）;
	*/
	function qiongju ($yuans,$yus=array(),$benfen,$Jduosan=1,$Jliansan=1) {
		/*echo '<br>在 $benfen='.$benfen.' 进行了qiongju()。';
		if ($benfen<=4) {
			print_r($yuans);
			print_r($yus);
			echo '<br>kkk',count($yuans[0]),'kk',count($yuans[1]),'kkkkk',count($yus[0]),'kkk',count($yus[1]),'kk';
		    if (count($yuans[0])==8) {
		    	var_export($yuans);
		    	echo "<br>ggggggggggggggg<br>";
		    	var_export($yus);
		    }
		    exit;
		}*/
			global $g_geshu;
			global $g_fanhui;
			$g_fanhui=array('qianyuzhi'=>0,
							'qianpeidui'=>array(),
							'qianjifencha'=>0,
							'qianxianshuhe'=>0,
							'qianshangxiazhi'=>0,
							'benfen'=>$benfen,
							'qian'=>array());
			global $peidui;
			$peidui=array();
			$fanhui=array();
			$jifens=array();
			$xianshus=array();
			$keduishu=array();
/*if ($benfen==3) {

}*/
			if ($yus[0]||$yus[1]) {
				//两个参数时为yipei()的余原配对
				//$yuans $yus  目标：尽可能配完$yus，再尽可能平衡先后手
				global $yuan;
				global $yu;
					/////注意前面用过的，定义后数值直接进来了，可能发生意外，所以还要清空（
					$yuan=array();
					$yu=array();
				$yuan=array_hebing($yuans[0],$yuans[1]);
				$yu=array_hebing($yus[0],$yus[1]);

				foreach ($yu as $key => $value) {
					$jifens[]=$value['xs_zongfen'];
					$xianshus[]=abs($value['xs_xianshu']);
					$yu[$key]['kedui']=array();
					$towhos=$yu[$key]['xs_towhos'];
					foreach ($yuan as $ke => $val) {
						if (peiduipan($yu[$key],$val,$Jduosan,$Jliansan)) {
							//增加TTbuyu、SXtiao的考虑，根据bsinfo各个可选；第三参数选择是否考虑多三、连三、
							$yu[$key]['kedui'][]=$ke;
						}
					}
					$keduishu[]=count($yu[$key]['kedui']);
				}
				if (isset($yu[1])) { //只有一个时，不用重新排序了！没有排序和键的重排会发生错误！
 				    array_multisort($jifens,SORT_DESC,$xianshus,SORT_DESC,$keduishu,$yu);
                }
                /////必须重新排列，kedui只是对数字键有效
                foreach ($yu as $key => $value) {
					$yu[$key]['kedui']=array();
					foreach ($yuan as $ke => $val) {
						if (peiduipan($yu[$key],$val,$Jduosan,$Jliansan)) {
							//增加Jliansan、TTbuyu、SXtiao的考虑，根据bsinfo各个可选
							$yu[$key]['kedui'][]=$ke;
						}
					}
				}
				//////
                $g_geshu=count($yu);
				yuquanpei(0,$benfen);	
				$duihao=0;
				$fanhui[1]=array();			
				foreach ($g_fanhui['qianpeidui'] as $dui) {
					if (isset($dui[0])&&$dui[0]!=='') {
						if ($yu[$dui[1]]['xs_xianshu']<$yuan[$dui[0]]['xs_xianshu']) {
							$fanhui[0][$duihao][0]=$yu[$dui[1]];
						    $fanhui[0][$duihao][1]=$yuan[$dui[0]];  	
						}else{
							$fanhui[0][$duihao][0]=$yuan[$dui[0]];
						    $fanhui[0][$duihao][1]=$yu[$dui[1]];   
						}
						$duihao++;
						//$fanhui[1]返回的是可配对的选手的序号
						isset($yuan[$dui[0]]['xs_xuhao'])?$fanhui[1][]=$yuan[$dui[0]]['xs_xuhao']:''; //yuan对应0组的！
						isset($yu[$dui[1]]['xs_xuhao'])?$fanhui[1][]=$yu[$dui[1]]['xs_xuhao']:'';
					}
				}
	       }else {
				//只一个参数则为fangan()里的拆余配对时的
				//$yuans  为$chengyuan
				global $chengyuan;
				$chengyuan=array_hebing($yuans[0],$yuans[1]);
				foreach ($chengyuan as $key => $value) {
					$jifens[]=$value['xs_zongfen'];
					$xianshus[]=abs($value['xs_xianshu']);
					$chengyuan[$key]['kedui']=array();
					$towhos=$chengyuan[$key]['xs_towhos'];
					foreach ($chengyuan as $ke => $val) {
						if (peiduipan($chengyuan[$key],$val,$Jduosan,$Jliansan)
						   &&($ke!=$key)) {//增加Jliansan、TTbuyu、SXtiao的考虑，根据bsinfo各个可选
							$chengyuan[$key]['kedui'][]=$ke;
						}
					}
					$keduishu[]=count($chengyuan[$key]['kedui']);
				}
				if (isset($chengyuan[1])) { //只有一个时，不用重新排序了！没有排序和键的重排会发生错误！
 				     array_multisort($jifens,SORT_DESC,$xianshus,SORT_DESC,$keduishu,$chengyuan);
				}
				/////////kedui只是对数字键值有效，所以必须重新排列////////
				foreach ($chengyuan as $key => $value) {
					$chengyuan[$key]['kedui']=array();
					foreach ($chengyuan as $ke => $val) {
						if (peiduipan($chengyuan[$key],$val,$Jduosan,$Jliansan)
						   &&($ke!=$key)) {//增加Jliansan、TTbuyu、SXtiao的考虑，根据bsinfo各个可选
							$chengyuan[$key]['kedui'][]=$ke;
						}
					}
				}
				///////////////////
				$g_geshu=count($chengyuan);
				quanquanpei(0,$benfen);
				$duihao=0;
				$fanhui[1]=array();
				foreach ($g_fanhui['qianpeidui'] as $dui) {
					if (isset($dui[0])&&$dui[0]!=='') {
						if ($chengyuan[$dui[0]]['xs_xianshu']<$chengyuan[$dui[1]]['xs_xianshu']) {
							$fanhui[0][$duihao][0]=$chengyuan[$dui[0]];
						    $fanhui[0][$duihao][1]=$chengyuan[$dui[1]];  	
						}else{
							$fanhui[0][$duihao][0]=$chengyuan[$dui[1]];
						    $fanhui[0][$duihao][1]=$chengyuan[$dui[0]];   
						}
						$duihao++;
						//$fanhui[1]返回的是可配对的选手的序号
						isset($chengyuan[$dui[0]]['xs_xuhao'])?$fanhui[1][]=$chengyuan[$dui[0]]['xs_xuhao']:'';
					    isset($chengyuan[$dui[1]]['xs_xuhao'])?$fanhui[1][]=$chengyuan[$dui[1]]['xs_xuhao']:''; 
					}
				}
				//理想情况是出现全部配完后剩下一个本分段本来的项
			}
			//注意：不要带xs_zt的值到$fanhui中//////剩余项数组还要分先后行
		    $fanhui[2]=$g_fanhui['qianyuzhi'];  //剩余项标准比较值
//echo $GLOBALS['g_fanhui']['qianyuzhi'];
//    echo $g_fanhui['qianyuzhi'];
//    print_r($g_fanhui['qianpeidui']);
//    echo $g_fanhui['benfen'].'<br>';
//    print_r($fanhui);
		    return $fanhui;
		    //fanhui【1】为已经配对的项的xs_xuhao
	}
	
	/**
	* 功能：剩余项数目的比较标准值，考虑多个高分层
	* 参数：$yus 剩余的项(数量>0,可以是单排或分先手行的)，[0]为要先行，[1]为要后行；$benfen 分数段本来的积分
	* 返回：剩余项数目的比较标准值
	*/
	function yuzhi($yus,$benfen){
	   	  $yuzhi=0;      //剩余项的比较标准值，逐层高分以100倍递增
	  if ($yus[0]||$yus[1]) {
		  	
	   	  $fenceng=0; 
	   	  isset($yus[0][0]['xs_zongfen'])||isset($yus[1][0]['xs_zongfen'])?$linshi=array_hebing($yus[0],$yus[1]):$linshi=$yus;
   	  	  // $linshi=array_hebing($yus[0],$yus[1]);它可以是单行或双行的
	   	  //为兼容1:0.5:0:1:0.5:0分制的情况，此种情况下将总分*2后再处理
		  	if ($GLOBALS['bsinfo']['bs_jufenmoshi']=='1:0.5:0:1:0.5:0'
		  	||$GLOBALS['bsinfo']['bs_jufenmoshi']=='1,0.5,0,1,0.5,0'
		  	||$GLOBALS['bsinfo']['bs_jufenmoshi']=='1;0.5;0;1;0.5;0') {
	            $benfen=2*$benfen; //最后是否要恢复呢？可能属于局部变量
	            foreach ($linshi as $key => $value) {
			  		$linshi[$key]['xs_zongfen']=$value['xs_zongfen']*2;
			  	}
		  	}
   	  	  foreach ($linshi as $value) {
	   	  	$linshifen[]=$value['xs_zongfen'];
	   	  } 
		  if ($linshi[1]) {
		      sort($linshifen);  	//当本函数结束时数组单元将被从最低到最高重新安排。
	   	  }
	   	  foreach ($linshifen as $value) {
	   	  	if ($value==$benfen) {
	   	  		if ($fenceng) {
	   	  			$yuzhi+=pow(100,$fenceng);
	   	  		}else {
	   	  			$yuzhi++;
	   	  		}
	   	  	}else{
	   	  		$fenceng=$value-$benfen;  //注意：积分不能是小数
	   	  		$yuzhi+=pow(100,$fenceng);	
	   	  	}
	   	  }
	   	  return $yuzhi;	  	
   	  }else{
   	  	return $yuzhi;
   	  }
   	   //////////////////////////需要算法改进的///////////////////////////////
	}
	
	/**
	* 功能：qiongju()传来yuans和yus时（虽然返回的yuzhi不准确，但外部比较百位以上的数就可以知道下调的项的配剩多少了）
	* 参数：$ceng 
	* 返回：无返回，修改qiongju内的变量
	*/
	function yuquanpei($ceng,$benfen='chucuo') {
		static $jishuyu;$jishuyu++;
		
		global $yu;
		global $yuan;
		global $peidui;
        //$GLOBALS['g_fanhui']['qianyuzhi']=888888;
		$key=$ceng;
		for ($i=0;$i<=count($yu[$key]['kedui']);$i++) {
/*			if ($key===0) {
				//初始化['did]为0；
				foreach ($yuan as $linshi =>$linshi2) {
					$yuan[$linshi]['did']=0;
				}
			}*/
			if (isset($yu[$key]['kedui'][$i])) {	
				$yuankey=$yu[$key]['kedui'][$i];
				if (!$yuan[$yuankey]['did']) {
				    //如果前一次赋值过 did 则恢复他们
					//if ($peidui[$key][0]==$GLOBALS['g_fanhui']['qian'][$key][0]&&isset($peidui[$key])&&$peidui[$key][0]!=='') {//同一行，前面有配对过才能回复上次对的yuan项
					if (isset($peidui[$key])&&$peidui[$key][0]!=='') {//同一行，前面有配对过才能回复上次对的yuan项
						$yuan[$GLOBALS['g_fanhui']['qian'][$key][0]]['did']=0;  //有必要，防止下下分段的穷举
					}
					//获取yuan yu的配对时的各自键值
					$peidui[$key][0]=$yuankey;     //yuan的键值
					$peidui[$key][1]=$key;         //yu的键值
					$yuan[$yuankey]['did']=1;
					$yu[$key]['did']=1;
					$GLOBALS['g_fanhui']['qian'][$key][0]=$yuankey;
					//$qian2=$key;
				}else{
					continue;  //此$yu[]不配对的情况已经在最后处理了，这里不用再次处理了
				}
			}else{
				if(isset($peidui[$key])&&$peidui[$key][0]!=='') {//同一行，前面有配对过才能回复上次对的yuan项
					$yuan[$GLOBALS['g_fanhui']['qian'][$key][0]]['did']=0;
				}
				$yu[$key]['did']=0;
				//应该恢复下的，但还没确定！？
				$GLOBALS['g_fanhui']['qian'][$key][0]='';
				//获取yuan yu的配对时的各自键值
//				$peidui[$key][0]='';         //yuan的键值
//				$peidui[$key][1]='';         //yu的键值
                unset($peidui[$key]);
			}
			if ($key<$GLOBALS['g_geshu']-1) {
				    yuquanpei($key+1,$benfen);
			}else {
					//一个方案结束，
					//获取所有 未使用 的 余项（即上分段下调的），计算出yuzhi
					//先比较剩余项比较标准值，jifencha、xianshuhe（只考虑配对的）、shangxiazhi
					//由于只需尽量配完yu
					$shengyu=array();
					foreach ($yu as $yukey => $yuvalue) {
						if (!$yuvalue['did']) {
							$shengyu[]=$yuvalue;
						}
					}
					
					//去掉$peidui中的空项
					foreach ($peidui as $pdkey => $dui) {
						if ($dui[0]==='') {
							unset($peidui[$pdkey]);
						}
					}
					
					//检查先后手情况
					if (count($peidui)) {
						$linshi=1;
						/*  因为已经在qiongju确定了可配对的范围，不用再考虑禁
						foreach ($peidui as $dui) {
							if (!peiduipan($yuan[$dui[0]],$yuan[$dui[1]],0,0) ) {
								$linshi=0;  //产生多三先或多三后、同队考虑回避的话 直接排除；因为已经在qiongju确定了可配对的范围，不用再考虑禁止多三连三了
								break;
							}
						}*/
						if ($linshi) {
						    //获取已配对peiduis台次选手数组，使用peidui的选手序号配对数组！注意：平衡先后的计算只能用xianshuhe
							$peiduis=array();
							foreach ($peidui as $pdkey => $dui) {
							    $peiduis[$pdkey][0]=$yuan[$dui[0]];
								$peiduis[$pdkey][1]=$yu[$dui[1]];
							}
						
							if ($GLOBALS['g_fanhui']['qianpeidui']) {
								//比较剩余项比较标准值
								$yuzhi=yuzhi($shengyu,$GLOBALS['g_fanhui']['benfen']);
								if ($yuzhi<$GLOBALS['g_fanhui']['qianyuzhi']) {
								
										$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
										$GLOBALS['g_fanhui']['qianyuzhi']=$yuzhi;
										$GLOBALS['g_fanhui']['qianjifencha']=jifencha($peiduis,array(),$benfen);
										$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,array());
										$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,array());
										
								}elseif ($yuzhi==$GLOBALS['g_fanhui']['qianyuzhi']) {
									
									 	//yuzhi相等，再比较jifencha
										$jifencha=jifencha($peiduis,array(),$benfen);   //因为只要配完yu，所以shengyu不考虑也不影响
										if ($jifencha>$GLOBALS['g_fanhui']['qianjifencha']) {
											
											$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
											$GLOBALS['g_fanhui']['qianjifencha']=$jifencha;
											$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,array());
											$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,array());
											
										} elseif ($jifencha==$GLOBALS['g_fanhui']['qianjifencha']) {
										        
												//jifencha相等，再比较xianshuhe
												$xianshuhe=xianshuhe($peiduis,array());    //不需要shengyu也可以
												if ($xianshuhe>$GLOBALS['g_fanhui']['qianxianshuhe']) {//使用分数，数值大的较优！
												
														$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
														$GLOBALS['g_fanhui']['qianxianshuhe']=$xianshuhe;	
														$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,array());
														
												} elseif ($xianshuhe==$GLOBALS['g_fanhui']['qianxianshuhe']) {
													//xianshuhe相等，再先考虑上下调平衡
													$shangxiazhi=shangxiazhi($peiduis,array());
													if ($shangxiazhi<$GLOBALS['g_fanhui']['qianshangxiazhi']) {
														$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
														$GLOBALS['g_fanhui']['qianshangxiazhi']=$shangxiazhi;
													} elseif ($shangxiazhi==$GLOBALS['g_fanhui']['qianshangxiazhi']) {
													    //暂时没有再比较的因素了
													    //break; //暂时这样！！！！！！！	测试需要；实际不能使用！
													}
												}
										}
								}
							}else{
								//可以看做是第一次赋值，因为['qianyuzhi']初始为0
								$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
								$GLOBALS['g_fanhui']['qianyuzhi']=yuzhi($shengyu,$GLOBALS['g_fanhui']['benfen']);
								$GLOBALS['g_fanhui']['qianjifencha']=jifencha($peiduis,array(),$benfen);
								$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,array());
								$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,array());
							}
						}
					}
					//没有新的配对产生是直接排除的
			}
		}
	}

	/**
	* 功能：qiongju()传来chengyuan时，进行的函数
	* 参数：
	* 返回：无返回，修改qiongju内的变量
	*/
	function quanquanpei($ceng,$benfen='chucuo'){
		static $jishuquan;$jishuquan++;
		
		global $chengyuan;
		global $peidui;
		$key=$ceng;
		for ($i=0;$i<=count($chengyuan[$key]['kedui']);$i++) {
			if (!$key) {
				//初始化['did]为0；chengyuan余yu、yuan不同，增加了yu的判断
				foreach ($chengyuan as $linshi =>$linshi2) {
					$chengyuan[$linshi]['did']=0; //有必要，防止下下分段的穷举
				}
				$peidui[0][0]='';
				$peidui[0][1]='';
				//unset($peidui[0]);
			}
			if (isset($chengyuan[$key]['kedui'][$i])) {	
			    $yuankey=$chengyuan[$key]['kedui'][$i];
			    //非首层需要，但首层的会跳除一些取值；上些层使用过的不能再使用了
				if ($key) {
					if ($chengyuan[$key]['did']&&(!isset($peidui[$key])||$peidui[$key][0]==='')) {
						unset($peidui[$key]);
						continue;
					}
				}
			    
				if (!$chengyuan[$yuankey]['did']) {
					//if (isset($GLOBALS['g_fanhui']['qian'][$key][0])) {
					if (isset($peidui[$key][0])&&$peidui[$key][0]!=='') {//同一行，前面有配对过才能回复上次对的yuan项
						$chengyuan[$GLOBALS['g_fanhui']['qian'][$key][0]]['did']=0;
						$chengyuan[$GLOBALS['g_fanhui']['qian'][$key][1]]['did']=0;
					}
					//获取yuan yu的配对时的各自键值
					$peidui[$key][0]=$yuankey;     //yuan的键值
					$peidui[$key][1]=$key;         //yu的键值
					$chengyuan[$yuankey]['did']=1;
					$chengyuan[$key]['did']=1;
					$GLOBALS['g_fanhui']['qian'][$key][0]=$yuankey;
					$GLOBALS['g_fanhui']['qian'][$key][1]=$key;
				}else{
					continue;  //此$yu[]不配对的情况已经在最后处理了，这里不用再次处理了
				}
			}else{
				if(isset($peidui[$key][0])&&$peidui[$key][0]!=='') {//要同一行，前面有过配对才能考虑这个
					$chengyuan[$GLOBALS['g_fanhui']['qian'][$key][0]]['did']=0;
					$chengyuan[$GLOBALS['g_fanhui']['qian'][$key][1]]['did']=0;
				}
				//最后一个不用回复为0！！！！！？？？？？？
				//应该恢复下的，但还没确定！？
				$GLOBALS['g_fanhui']['qian'][$key][0]='';
				$GLOBALS['g_fanhui']['qian'][$key][1]='';
				//获取yuan yu的配对时的各自键值
				unset($peidui[$key]);
			}
			if ($key<$GLOBALS['g_geshu']-1) {
				    quanquanpei($key+1,$benfen);
			} else {
					//一个方案结束，
					//获取所有未使用的剩余项，计算出yuzhi
					//先比较剩余项比较标准值，再比较xianshu的和方
					$shengyu=array();
					foreach ($chengyuan as $yukey => $yuvalue) {
						if (!$yuvalue['did']) {
							$shengyu[]=$yuvalue;
						}
					} 
/* if (count($peidui)==7) {
	echo '<br>kkk/n';
	print_r($peidui);
}*/
/*	if (count($peidui)>=8) {
	print_r($peidui);
}*/
/*   if ($peidui[14]) {
	print_r($peidui[14]);
}*/
					//去掉$peidui中的空项					
					foreach ($peidui as $pdkey => $dui) {
						if ($dui[0]==='') {
							unset($peidui[$pdkey]);
						}
					}

					if (count($peidui)) {  //只有生成peidui不空才考虑继续
						$linshi=1;
						/*  由于在qiongju中已经过滤过了，这里不用，以免影响性能
						foreach ($peidui as $dui) {
							if (!peiduipan($chengyuan[$dui[0]],$chengyuan[$dui[1]],0,0)) {
								$linshi=0;  //产生多三先或多三后、如果本队回避的话也直接排除
								break;
							}
						}
						*/
						if ($linshi) {
						    //获取配对的台次选手数组，暂时以0开始
							$peiduis=array();
							foreach($peidui as $pdkey => $dui) {
							    $peiduis[$pdkey][0]=$chengyuan[$dui[0]];
								$peiduis[$pdkey][1]=$chengyuan[$dui[1]];
							}
						
							if ($GLOBALS['g_fanhui']['qianpeidui']) {
								$yuzhi=yuzhi($shengyu,$GLOBALS['g_fanhui']['benfen']);  //剩余项比较标准值
								if ((!isset($GLOBALS['bsinfo']['bs_lunkongmoshi']))||(!$GLOBALS['bsinfo']['bs_lunkongmoshi'])) { //默认模式是轮空过不能再轮空
									if ($GLOBALS['g_mofenduan']) {
									//穷举时，剔除不符合条件的，不在zuidiwei数组内 //没轮空过的最低分项
									//同时在erpei中判断   //不能用yuzhi=250的办法了！！！
										if (count($shengyu)==1) { 
//print_r($chengyuan);
//echo $shengyu[0]['xs_zongfen'],'<br>';
											if ($shengyu[0]['xs_zongfen']==$GLOBALS['g_lunkongfen']&&strpos($shengyu[0]['xs_towhos'],',0,')===false) {
//echo 'GGGGG<BR>';
												$yuzhi=1;  //剩余项比较标准值，因为后面和qiongju最后没有再使用yuzhi()来重新获取，所以可以
												//break;
											} else {
												$yuzhi=50;
											}
										}
									}
								} else {
									//最后一分段的，只取剩余一个本分项的方案 即要yuzhi==1；
									if ($yuzhi==1&&$GLOBALS['g_mofenduan']) {
										//剩余项必须是最低分且 不 对过空号的项，
	    								$yuzhi=50;  //大于1的方案的对于最后分段来说都是要废掉的，因为外面也做了只能输出最低分的限制
										foreach ($GLOBALS['g_zuidishao'] as $linshi) {
											if ($shengyu[0]['xs_xuhao']==$linshi['xs_xuhao']){
												$yuzhi=1;  //剩余项比较标准值
												break;
											}
										}
									}
								}
/*
if ($GLOBALS['g_mofenduan']) {
	if ($shengyu[0]['xs_xuhao']==16
	   ||$shengyu[0]['xs_xuhao']==31
	   ||$shengyu[0]['xs_xuhao']==1) {
		echo $shengyu[0]['xs_xuhao'],'GGGHHH';
		$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
	}
}
*/
								if ($yuzhi<$GLOBALS['g_fanhui']['qianyuzhi']) {  //比较剩余项比较标准值
								
										$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
										$GLOBALS['g_fanhui']['qianyuzhi']=$yuzhi;
										$GLOBALS['g_fanhui']['qianjifencha']=jifencha($peiduis,$shengyu,$benfen);	
										$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,$shengyu);	
										$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,$shengyu);	
										
								}elseif ($yuzhi==$GLOBALS['g_fanhui']['qianyuzhi']) {
								
										//yuzhi相等，再比较两人积分的差方；未配对的对手积分假设为0
										$jifencha=jifencha($peiduis,$shengyu,$benfen);
										if ($jifencha>$GLOBALS['g_fanhui']['jifencha']) {
										
												$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
												$GLOBALS['g_fanhui']['qianjifencha']=$jifencha;	
												$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,$shengyu);	
												$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,$shengyu);	
												
										}elseif ($jifencha==$GLOBALS['g_fanhui']['jifencha']) {
										
												//yuzhi相等，且jifencha也相等，再比较xianshu的和方
												$xianshuhe=xianshuhe($peiduis,$shengyu);	
												if ($xianshuhe>$GLOBALS['g_fanhui']['qianxianshuhe']) { //使用分数，数值大的较优！
												
														$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
														$GLOBALS['g_fanhui']['qianxianshuhe']=$xianshuhe;	
														$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,$shengyu);	
														
												} elseif ($xianshuhe==$GLOBALS['g_fanhui']['qianxianshuhe']) {
														//xianshuhe相等，再比较上下调标准值
														$shangxiazhi=shangxiazhi($peiduis,$shengyu);	
														if ($shangxiazhi<$GLOBALS['g_fanhui']['qianshangxiazhi']) {
														
															$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
															$GLOBALS['g_fanhui']['qianshangxiazhi']=$shangxiazhi;
														
														} elseif ($shangxiazhi==$GLOBALS['g_fanhui']['qianshangxiazhi']) {
														    // 后面暂时没有比较因素了	
														    //break; //暂时这样！！！！！！！	测试需要；实际是不能使用的！												
														}
												}
										}	
								}
							} else {
								//可以看做是第一次赋值，因为['qianpeidui']初始为0；需在qiongju()开始初始化！
								$GLOBALS['g_fanhui']['qianpeidui']=$peidui;  //配对的项的键值数组
								$yuzhi=yuzhi($shengyu,$GLOBALS['g_fanhui']['benfen']); //$GLOBALS['g_fanhui']['qianyuzhi']=yuzhi($shengyu,$GLOBALS['g_fanhui']['benfen']);
								$GLOBALS['g_fanhui']['qianjifencha']=jifencha($peiduis,$shengyu,$benfen);	
								$GLOBALS['g_fanhui']['qianxianshuhe']=xianshuhe($peiduis,$shengyu);	
								$GLOBALS['g_fanhui']['qianshangxiazhi']=shangxiazhi($peiduis,$shengyu);
								if ((!isset($GLOBALS['bsinfo']['bs_lunkongmoshi']))||(!$GLOBALS['bsinfo']['bs_lunkongmoshi'])) { //默认模式是轮空过不能再轮空
									if ($GLOBALS['g_mofenduan']) {	
//print_r($GLOBALS['g_zuidiwei']);
//exit;
										//且奇数个剩余或 只剩一项的情况
										if (count($shengyu)==1) {
										    if ($shengyu[0]['xs_zongfen']==$GLOBALS['g_lunkongfen']&&strpos($shengyu[0]['xs_towhos'],',0,')===false) {
										    	$yuzhi=1;  //剩余项比较标准值，因为后面和qiongju最后没有再使用yuzhi()来重新获取，所以可以
												//break;
											} else {
												$yuzhi=49; //当只有一项剩余时，排除其积分和lunkongfen相等的项（它的yuzhi=1 ！）
											}
										}
									}
								} else {
									//最后一分段且为奇数个时，考虑取最低分对空号（如果需要空号的话），取对过空号最少的最低分
									if ($yuzhi==1&&$GLOBALS['g_mofenduan']) {
										//剩余项必须是最低分项，对过空号次数最少的项，
	   									$GLOBALS['g_fanhui']['qianyuzhi']=30;  //用意是废掉此方案，因为外面也做了只能输出最低分的限制
										foreach ($GLOBALS['g_zuidishao'] as $linshi) {
											if ($shengyu[0]['xs_xuhao']==$linshi['xs_xuhao']){
												$yuzhi=1;
												break;
											}
										}
									}	
								}
								$GLOBALS['g_fanhui']['qianyuzhi']=$yuzhi;  //默认状态的取值，后面可能会修改它
							}
						}
					}
					//没有新的配对产生是直接排除的
			}
		}
	}

	/**
	* 功能：配对进行时的同队、连三、上下调的相关判断；还提供选择是否检验多三、连三
	* 参数：准备配对的两个选手,$c是否检查相遇选手和多三，$d 未具体定义、未使用
	* 返回：true可以相遇 or false不能相遇
	*/
	function peiduipan($a,$b,$Jduosan=1,$Jliansan=1) {

		//禁止相遇过的选手相遇的
		if (strpos($a['xs_towhos'],','.$b['xs_xuhao'].',')!==false) {
		    return false;
		}
		
		if($Jduosan) {   //$c=true,要检查多三
			//禁止多三，（是否在此处理这个呢？）
			if($GLOBALS['bsinfo']['bs_Jduosan']){ 
				if ($a['xs_xianshu']*$b['xs_xianshu']>0) {//判断，是同行
					if (abs($a['xs_xianshu'])>150&&abs($b['xs_xianshu'])>150) {
				         return false;
					}
				}
			}
		}
		
		if($Jliansan) {   //$c=true,要检查连三
			//是否禁止连三，（注意：禁连三最好默认禁多三，因为某些情况特殊）
			if($GLOBALS['bsinfo']['bs_Jliansan']){  //true，禁止连三（目前的做法也去除了-98和101/102的情况:不该排除，98和-98的情况:不该排除，-98和202：应该排除 等）
					// 这是比较宽松一点的，（有可能出现1某些特殊类型，并导致xianshuhe标准值的比较不准确）（正在测试中。。。）
				    if($a['xs_xianshu']>$b['xs_xianshu']){//a的xianshu大于b的xianshu，b取先手
			             if(!($a['xs_xianshu']-round($a['xs_xianshu']/100)*100-1>-3
					       &&$b['xs_xianshu']-round($b['xs_xianshu']/100)*100+1<3)){
			                  return false;
			             }
					}else{
				         if(!($a['xs_xianshu']-round($a['xs_xianshu']/100)*100+1<3
						   &&$b['xs_xianshu']-round($b['xs_xianshu']/100)*100-1>-3)){
				              return false;
				         }
					}
					//  注意：百位数字的差必定是偶数，包括0！！！
					
					/*
					//严格的筛选，xianshu决定了两者的先后手，但会缺少某些配对类型，（暂不考虑）
					//101和2 不可能同时存在；百位数字的差必定是偶数，包括0！！！
					$value[abs($i-1)]['xs_xianshu']-round($value[abs($i-1)]['xs_xianshu']/100)*100+1<3
					&&$value[$i]['xs_xianshu']-round($value[$i]['xs_xianshu']/100)*100-1>-3
					&&round($value[abs($i-1)]['xs_xianshu']/100)+1<3
					&&round($value[$i]['xs_xianshu']/100)-1>-3
					*/
			}
		}
		
		//是否禁止同队相遇
		if($GLOBALS['bsinfo']['bs_TTbuyu']){//true,禁止同队相遇
		     if($a['xs_danwei']==$b['xs_danwei']){
		          return false;
		     }
		}
		//$GLOBALS['bsinfo']['bs_SXtiao'])考虑调整上下调，但不在这里过滤
	return true;
	}
	

	/**
	* 功能：已配对的对手间（剩余的按对到0）的两xianshu值各自的百位数字之和的绝对值作为1/100的指数所得到的值 的总和（越大越优）
	* 参数：$peiduis 此段中已经配对的台次； $shengyus此段配对后剩余的项集合（shengyu为空效果不影响）
	* 返回：先后手平衡算法的标准值
	*/
	function xianshuhe($peiduis,$shengyus=array()){
		$xianshuhe=0;
		if ($peiduis) {
			foreach ($peiduis as $value) {
//				$xianshuhe+=pow(($value[0]['xs_xianshu']+$value[1]['xs_xianshu']),4);  //这种是值越小越优
				$xianshuhe+=pow(100,(0-abs(round(($value[0]['xs_xianshu']+$value[1]['xs_xianshu'])/100)))); //这种的值越大越优；且只考虑百位数字，即多或缺的先后手
			}	
		}
		if ($shengyus) {  //一般不需要的，但可能是201和-1、101和-1 ，剩余201就相等了了 
			if (!isset($shengyus[0]['xs_id'])) {  //单行数组
				$shengyus=array_hebing($shengyus[0],$shengyus[1]);  //双行数组要先转换为单行的
			}
			foreach ($shengyus as $value) {
//				$xianshuhe+=pow($value['xs_xianshu'],4);
				$xianshuhe+=pow(100,(0-abs(round($value['xs_xianshu']/100)))); //这种的值越大越优；且只考虑百位数字，即多或缺的先后手
//				！！这个在这里可能会有 3=1  与2=1 分别剩余2和3；理想是使用后者？！因为3下调后还有机会；所以上面可以保留
			}
		}
		return $xianshuhe;
	}

	/**
	* 功能：一分段中已配对的积分差平方与剩余项积分平方之和（qiongju()中使用）注意：0.5的情况，暂时*10
	* 参数：$peiduis 此段中已经配对的台次； $shengyus此段配对后剩余的项集合（如果是余原的quanpei，则shengyu为空效果不影响）;benfen 用于评估分级
	* $chengyuan,$shengyu,$peidui=已配对的chengyuan键值的数组
	* 返回：一分段中已配对的积分差平方与剩余项积分平方之和
	*/
	function jifencha($peiduis,$shengyus=array(),$benfen='chucuo') {
		$jifencha=0;
		
		if ($peiduis) {
			foreach ($peiduis as $value) { //已配对的[$dui[0]]['xs_zongfen']-$chengyuan[$dui[1]]['xs_zongfen']));
//				$jifencha+=pow(10*($value[0]['xs_zongfen']-$value[1]['xs_zongfen']),2);  //不准确；没有考虑高分的优先配对！！			
/*if ($value[0]['xs_zongfen']>$value[1]['xs_zongfen']) { //大分尽量配对相近积分的项，也不成功
	$jifencha+=pow(100,($value[0]['xs_zongfen']-$benfen));
	//可以兼容0.5分制的 0.5（0.5-0），因为底数10也勉强了
} else {
	$jifencha+=pow(100,($value[1]['xs_zongfen']-$benfen));
	//可以兼容0.5分制的，因为底数10也勉强了
}*/
				$jifencha+=pow(100,($value[0]['xs_zongfen']+$value[1]['xs_zongfen']-2*$benfen)); //大的较优！
			}	
		}
		if($shengyus){
			if (!isset($shengyus[0]['xs_id'])) {
				$shengyus=array_hebing($shengyus[0],$shengyus[1]);
			}
			foreach ($shengyus as $value) { //剩余的
//				$jifencha+=pow($value['xs_zongfen']*10,2); 
				$jifencha+=pow(100,($value['xs_zongfen']-$benfen)); 
//				$jifencha+=pow(100,($value['xs_zongfen']+($benfen-1)-2*$benfen));  //不能兼容积分为0的情况
			}
		}
		return $jifencha;
	}

	/**
	* 功能：在最后一分段中获取最低分项中的对过空号最少的项
	* 参数：最后一份段中的所有项，而不是qiongju中的部分；由于是fd[]的，所以分为0、1两行
	* 返回：在最后一分段中获取最低分项中的对过空号最少的项，数组，一个时[0]
	*/
	function zuidishao($fdzuihou) {
		$zuidishao=array();
		$linshi=array_hebing($fdzuihou[0],$fdzuihou[1]);  //由于是fd的，所以分为0、1两行
		$duiguo=substr_count($linshi[0]['xs_towhos'],",0,");
		foreach ($linshi as $value) {
			$nowduiguo=substr_count($value['xs_towhos'],",0,");
			if ($nowduiguo<$duiguo) {               //取对过更少的
				$zuidishao=array();
				$zuidishao[]=$value;
				$duiguo=$nowduiguo;
			}elseif ($nowduiguo==$duiguo) {         //增加一样少的
				$zuidishao[]=$value;
			}
		}
		return $zuidishao;
	}

	/**
	* 功能：可以轮空的选手的积分值，一般指没轮空过的最低分选手
	* 参数：全部项；由于是fd的全部，fd[积分段][0/1]
	* 返回：可以轮空的选手的积分值，一般指没轮空过的最低分选手
	*/
	function lunkongfen ($fd) {
		$zuidiwei=array();
		//从小分开始搜索
		$linshi=count($fd)-1;
		for ($i=$linshi;$i>=0;$i--) {
			if ($fd[$i][0]) {
				foreach ($fd[$i][0] as $value) {
					if (strpos($value['xs_towhos'],',0,')===false) {
						$zuidiwei[]=$value;
					}
				}	
			}
			if ($fd[$i][1]) {
				foreach ($fd[$i][1] as $value) {
					if (strpos($value['xs_towhos'],',0,')===false) {
						$zuidiwei[]=$value;
					}
				}
			}
			if (count($zuidiwei)) {
				$lunkongfen=$zuidiwei[0]['xs_zongfen'];
				break;
			}
		}
		return $lunkongfen;
		//return $zuidiwei;
		//return array_hebing($fd[$i][0],$fd[$i][0]); //如果比赛的全部选手都已轮空过，则返回最低分段的所有项
	}
	
	/**
	* 功能：计算一段中配对后的上下调平衡的标准值（比较使用，如是余原的quanpei，不用传入shengyu）
	* 参数：$peiduis 此段中已经配对的台次； $shengyus此段配对后剩余的项集合
	* 返回：上下调平衡的标准值（比较使用）
	*/
	function shangxiazhi($peiduis=array(),$shengyus=array()) {
		$shangxiazhi=0;
		if($GLOBALS['bsinfo']['bs_SXtiao']) { //如果考虑上下调，则计算值，否则全部为0即可
		
			//首先计算已经配对的上下调标准值
			if ($peiduis) {
				foreach ($peiduis as $key => $value) {
					if ($value[0]['xs_zongfen']!=$value[1]['xs_zongfen']) {
						if ($value[0]['xs_zongfen']>$value[1]['xs_zongfen']) {
							//红方下调；黑方上调
							$shangxiazhi+=pow(100,abs($value[0]['xs_shangxiacha']-1));
							$shangxiazhi+=pow(100,abs($value[1]['xs_shangxiacha']+1));
						} else {
							//红方下调；黑方上调
							$shangxiazhi+=pow(100,abs($value[0]['xs_shangxiacha']+1));
							$shangxiazhi+=pow(100,abs($value[1]['xs_shangxiacha']-1));
						}
					} else {
						//总分相等的只计算上下差的绝对值
						$shangxiazhi+=pow(100,abs($value[0]['xs_shangxiacha'])); 			    
						$shangxiazhi+=pow(100,abs($value[1]['xs_shangxiacha'])); 			    
					}
				}
				//$shengyus都是下调的	
			}
			if ($shengyus) {
				if (!isset($shengyus[0]['xs_id'])) {
					$shengyus=array_hebing($shengyus[0],$shengyus[1]);
				}
				foreach ($shengyus as $key => $value) {
					$shangxiazhi+=pow(100,abs($value['xs_shangxiacha']-1));
				}	
			}
		}
		return $shangxiazhi;
 //  注意：以后还考虑增加已经平衡上下调次数的 算法！
	}
?>  