<?php
/**
* FILE_NAME : diyilun.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\diyilun.php
* 编排第一轮的处理：5种配对方式，10种先后手安排方式（正规组合：3【拦腰】，2【单台小号先】/6【单台小号后】；娱乐组合：1【临近】，2【单台小先】/6【单台小后】）
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Mon Feb 01 14:37:23 CST 2010
*/

/**    详细全面的功能介绍，本页实现的只是里面的大部分
 *阶段：第一轮的编排
 *信息：
      *同一单位棋手(队)可在第一轮回避配对。其他轮次不易回避。
      *确定棋手（队）序列号
	  1、确定棋手（队）序列号
      序列号是编排工作的必要环节。排序方式一般有几种：
		⑴棋手无等级分的比赛。尤其是业余比赛，在不清楚谁水平高低的情况下，可以混编序列号。即用填好姓名的编排卡，采用洗牌的方式，然后一字排开，从头至尾，1、2、3、---，直至最后一名，每个人都确定了自己的序号。
		⑵有等级分棋手或已知棋手水平高低的比赛。按照参赛人（队）数，分成上下两个半区。水平高的在上半区，反之，在下半区。
		⑶采用队员总分制的方式，即在录取个人名次的同时，也录取团体名次的比赛。把本队棋手适当分开，如两人参赛，应分成上下半区，先后手也平衡。
		⑷序列号的区分方式可以选择。
			①上半区：1、3、5、7、9---，下半区：2、4、6、8、10---。即逢单号为上半区，双号下半区。
			②上半区：1、2、3、4、5、6、7、8、9、10---，下半区11、12、13---，依次排序。即上下半区中间部分对折。小号部分为上半区，大号部分为下半区。
       *第一轮编排配对方式/模式
			⑴第一轮配对有四种基本方式：
			①临近编排。1---2、3---4，5---6，---，直至编完。
			②首尾编排。1——20、2——19、3——18，---，即首尾相遇，依次靠拢，直至编完。
			③拦腰编排，1——11、2——12、3——13，即从上下两个半区中间位置断开，下半区的第一个号直接对1号，以后按顺序依次跟上，直至排完。
			④随机编排。即电脑生成配对。
			⑤上半区对下半区！由传来的[xs_banqu]??上面四种已经可以搭配出此种配对效果了
	⑵首轮同队棋手不相遇。那么在抽签配对时，若相遇，则在后边临近的那一对中互换位置，注意一定要下半区的人之间互换位置。
       *第一轮先后手决定方式/模式??先后手的决定方式列表：
			⑴上半区为先手，下半区为后手。
			⑵单数台次小号先手，双数台次大号先手。
			⑶单数序号先手，双数序号后手。
			⑷抽签决定，或者竞猜。
			⑸上半区为后手，下半区为先手。
			⑹单数台次号后手，双数台次大号先手。
			⑺单数序号后手，双数序号先手。
			⑻全部小号先
			⑼全部大号先
			⑽1-2,4-3,5-6,8-7
 */

/**
* 功能：进行第一轮的编排配对，根据传入的$peidui、$xianhou值1、实现5种配对方式；2、实现10种先后手安排方式
* 参数：$peidui=1-5，配对的方式，默认为3; $chengyuan按序号排列的选手列表；$xianhou 第一轮先后手的决定方式。
* 返回：配对好的对阵列表（包括确定先后手）$taici[0开始][]
*/
function diyilun($chengyuan,$peidui=3,$xianhou=2){
	//按选手序号排序，且检验数据是否符合规范
	$linshi=array();
	foreach ($chengyuan as $value) {
		$linshi[]=$value['xs_xuhao'];
	}
	array_multisort($linshi,$chengyuan);
	foreach ($chengyuan as $key => $value) {
		if ($value['xs_xuhao']!=$key+1) {
			$message='数据不够规范，请检查修正后重新编排(一般是指定退赛引起的)。错误提示：序号缺少，序号【'.($key+1).'】不存在！目前共'.count($chengyuan).'名选手';
			echo '<script>javascript:window.alert("',$message,'");</script>';
			break;
		}
	}
	//如果选手为单数则增加一个虚拟空号-即不保存到数据库中的
	if (count($chengyuan)%2) {
		$linshi=array();
		$linshi['xs_xuhao']=count($chengyuan)+1;
		$linshi['xs_name']='空号';
		$chengyuan[count($chengyuan)]=$linshi;
	}
	$taicis=peidui($chengyuan,$peidui);
	$taicis=taici($taicis,$xianhou);
	if ($taicis) {
		foreach ($taicis as $key => $value) {
			if ($value[0]['xs_name']=='空号') {
				$taicis[$key][0]['xs_xuhao']=0;
				break;
			} elseif ($value[1]['xs_name']=='空号') {
				$taicis[$key][1]['xs_xuhao']=0;
				break;
			}
		}	
	} else {
		
		exit('<script>alert("传入的台次数据为空，请重试或检查数据是否规范！即将返回原页面");window.history.back();</script>');
	}
    return $taicis;
}

/**
* 功能：根据传入的$peidui值，选择性进行配对
* 参数：$peidui=1-4，默认为3; $chengyuan
* 返回：$taici配对好的数据，默认小号在前，即[0]先手
*/
function peidui($chengyuan,$peidui) {
   $taici='';
   $banshu=sizeof($chengyuan)/2;//如果个数不为偶数，则会出错的！
   switch($peidui){
	   case 1:	//①临近编排。1---2、3---4，5---6，---，直至编完。
	     for($i=0;$i<$banshu;$i++){
		   $taici[$i][0]=$chengyuan[$i*2];
		   $taici[$i][1]=$chengyuan[$i*2+1];					 
		 }					   
		 break;
	   case 2:	//②首尾编排。1——20、2——19、3——18，---，即首尾相遇，依次靠拢，直至编完。
         for($i=0;$i<$banshu;$i++){
		   $taici[$i][0]=$chengyuan[$i];
		   $taici[$i][1]=$chengyuan[$banshu*2-1-$i];					 
		 }					   
		 break;
	   case 3:	//③拦腰编排，1—11、2—12、3—13，即从上下两个半区中间位置断开，下半区的第一个号直接对1号，以后按顺序依次跟上
		 for($i=0;$i<$banshu;$i++){
		   $taici[$i][0]=$chengyuan[$i];
		   $taici[$i][1]=$chengyuan[$banshu+$i];					 
		 }
		 break;
	   case 4:	//④随机编排。即电脑生成配对。
	   //暂时机器随机
	   	 shuffle($chengyuan);   //$chengyuan改变不影响后面，但奇数个选手时呢？只是不在最后一桌而已
	   	 for($i=0;$i<$banshu;$i++){
		   $taici[$i][0]=$chengyuan[$i];
		   $taici[$i][1]=$chengyuan[$banshu+$i];
		 }
	   	 //echo '暂时未提供此功能';
		 break;
	   case 5:	//⑤上半区对下半区！由传来的[xs_banqu] 0为不区分，1上，2下
			  /*⑷序列号的区分方式可以选择。
		①上半区：1、3、5、7、9---，下半区：2、4、6、8、10---。即逢单号为上半区，双号下半区。
		②上半区：1、2、3、4、5、6、7、8、9、10---，下半区11、12、13---，依次排序。即上下半区中间部分对折。小号部分为上半区，大号部分为下半区。
		这是要另外弄的 */
	     $shangs=$bufens=$xias=array();
	     for($i=0;$i<sizeof($chengyuan);$i++) {
			if ($chengyuan[$i][xs_banqu]==1) {
				$shangs[]=$chengyuan[$i];
			} elseif ($chengyuan[$i][xs_banqu]==2) {
				$xias[]=$chengyuan[$i];
			} else {
				$bufens[]=$chengyuan[$i];
			}
		 }
		 $xuanshous=array_merge($shangs,$bufens);
		 $xuanshous=array_merge($xuanshous,$xias);
		 for($i=0;$i<$banshu;$i++) {  // 默认按上下半区聚合后的首位配对；先后手为上先不分，不分先下，同随机
		     $taici[$i][0]=$xuanshous[$i];
		     $taici[$i][1]=$xuanshous[$banshu+$i];
		 }
		 break;
	   default://错误的传入值，提示错误！
	   
	   exit('<script>alert("传入的配对模式值不在范围内！返回原页面");window.history.back();</script>');  
	     //echo 'peidui=[1,5]';
		 break;
    }
	return $taici;
}
/**  第一轮配对有四种基本方式：
①临近编排。1---2、3---4，5---6，---，直至编完。
②首尾编排。1——20、2——19、3——18，---，即首尾相遇，依次靠拢，直至编完。
③拦腰编排，1——11、2——12、3——13，即从上下两个半区中间位置断开，下半区的第一个号直接对1号，以后按顺序依次跟上，直至排完。
④随机编排。即电脑生成配对。
⑤上半区对下半区！由传来的[xs_banqu]??上面四种已经可以搭配出此种配对效果了
	⑵首轮同队棋手不相遇。那么在抽签配对时，若相遇，则在后边临近的那一对中互换位置，注意一定要下半区的人之间互换位置。*/


/**
*功能：安排先后手，一共8种方式
*参数：peidui()函数处理后的$taici，和安排先后的方式的选择$xianhou=1-10
*返回：已按指定方式先后手的配对，$taici
*/
function taici($taici,$xianhou){
 //$taici=peidui();  //在前面已经执行过了
 //var_dump($taici);
		 switch($xianhou){
			   case 1://⑴上半区为先手，下半区为后手。!!!!如果配对的都是同一半区的呢！？则默认小号为先手
				  for($i=0;$i<sizeof($taici);$i++){	 
				  	//上半区先于不区分，不区分先于下半区，同半区不交换
				  	if ($taici[$i][1][xs_banqu]!=$taici[$i][0][xs_banqu]) { //不同半区才需交换
				  		if ($taici[$i][1][xs_banqu]==1) {
				  			$taici[$i]=array_reverse($taici[$i]);
				  		}elseif ($taici[$i][0][xs_banqu]==2) {
				  			$taici[$i]=array_reverse($taici[$i]);
				  		}
				  	}
				  	//if($taici[$i][1][xs_banqu]<$taici[$i][0][xs_banqu]){$taici[$i]=array_reverse($taici[$i]);}
				  }
				  break;
				  
			   case 2://⑵单数台次小号先手，双数台次大号先手。
				  for($i=0;$i<sizeof($taici);$i++){
					   if($i%2){//偶数台次，因为i=1时为第2台
						   $taici[$i][1]['xs_xuhao']>$taici[$i][0]['xs_xuhao']?$taici[$i]=array_reverse($taici[$i]):true;
					   }else{//奇数台次，因为i=0时为第一台
						   $taici[$i][1]['xs_xuhao']>$taici[$i][0]['xs_xuhao']?"":$taici[$i]=array_reverse($taici[$i]);
					   }
				  }
				  break;
				  
			   case 3://⑶单数序号先手，双数序号后手。
			     for($i=0;$i<sizeof($taici);$i++){
					   if(!$taici[$i][0][xs_xuhao]%2){
						   	  if($taici[$i][1][xs_xuhao]%2){
						   	  	  $taici[$i]=array_reverse($taici[$i]);
						   	  }
					   }
				 } 
				  break;
				  
			   case 4:	//⑷抽签决定，或者竞猜。 //这种方式也可以认为修改配对，目前是机器随机
				  for($i=0;$i<sizeof($taici);$i++) {
					   if (rand(0,100)>50) {
					   		$taici[$i]=array_reverse($taici[$i]);
					   }
				  }
			      //echo '暂时未提供此功能';
				  break;
				  
			   case 5:	//⑸上半区为后手，下半区为先手。上1 下2 不区分0！  如果还有不区分的呢，如果同半区相遇呢？？！
				  for($i=0;$i<sizeof($taici);$i++) {
				  	//上半区后于不区分，不区分后于下半区，同半区不交换
				  	if ($taici[$i][1][xs_banqu]!=$taici[$i][0][xs_banqu]) { //不同半区才需交换
				  		if ($taici[$i][1][xs_banqu]==2) {
				  			$taici[$i]=array_reverse($taici[$i]);
				  		}elseif ($taici[$i][0][xs_banqu]==1) {
				  			$taici[$i]=array_reverse($taici[$i]);
				  		}
				  	}
					//($taici[$i][1]['xs_banqu']<$taici[$i][0]['xs_banqu'])?'':$taici[$i]=array_reverse($taici[$i]);
				  }
				  break;
				  
			   case 6:	//⑹单数台次小号后手，双数台次大号先手。
			      for($i=0;$i<sizeof($taici);$i++){
					   if($i%2){	//偶数台次，因为i=1时为第2台
					     $taici[$i][1]['xs_xuhao']>$taici[$i][0]['xs_xuhao']?ture:$taici[$i]=array_reverse($taici[$i]);
					   }else{	//奇数台次，因为i=0时为第一台
					     $taici[$i][1]['xs_xuhao']>$taici[$i][0]['xs_xuhao']?$taici[$i]=array_reverse($taici[$i]):true;
					   }
				  }			 
				  break;
				  
			   case 7:	//⑺单数序号后手，双数序号先手。 先后都是同单双，不交换
			     for($i=0;$i<sizeof($taici);$i++) {
				   //xuhao=1时为单数序号，xuhao=0时为双数序号；
					   if ($taici[$i][0]['xs_xuhao']%2) { //先手单
						   	if (!$taici[$i][1][xs_xuhao]%2) { //后手双
						   		$taici[$i]=array_reverse($taici[$i]); //先手单，且后手双才交换=单数序号后手，双数序号先手。
						   	}
					   }
				 }
				  break;
			   case 8://⑻全部小号先
				 for($i=0;$i<sizeof($taici);$i++) {
				   $taici[$i][0]['xs_xuhao']>$taici[$i][1]['xs_xuhao']?$taici[$i]=array_reverse($taici[$i]):'';
				 }
				  break;
			   case 9://全部大号先
				 for($i=0;$i<sizeof($taici);$i++) {
				   $taici[$i][0]['xs_xuhao']>$taici[$i][1]['xs_xuhao']?'':$taici[$i]=array_reverse($taici[$i]);
				 }
				  break;
			   case 10://1-2,4-3,5-6,8-7  不要也罢！！
			   	  
			  	  exit('<script>alert("此先后手方式可通过配对和先后模式的配合得到，暂时不提供此功能！返回原页面");window.history.back();</script>');
				  
			  	  break;
			  case 11:	//不选择，由配对模式的默认先后手方式
			  
			      break; 
			   default://传入的值不在范围内，提示错误
			   	
			 	 exit('<script>alert("传入配对模式的值不在范围内！返回原页面");window.history.back();</script>');  
			     //echo 'xianhou=[1,10]';
				  break;	   
		 }
return $taici;
}	   
/**  先后手的决定方式列表：
⑴上半区为先手，下半区为后手。
⑵单数台次小号先手，双数台次大号先手。
⑶单数序号先手，双数序号后手。
⑷抽签决定，或者竞猜。
⑸上半区为后手，下半区为先手。
⑹单数台次小号后手，双数台次大号先手。
⑺单数序号后手，双数序号先手。
⑻全部小号先
⑼全部大号先
⑽1-2,4-3,5-6,8-7
*/	

?>