<?php




			
/*
A 对手分（所对弈过的全部对手的积分之和）；B 累进分（每轮积分相加总和）；C胜局；D 犯规；E后胜局（后手胜局）；F后手局（后手局数）；
  G 先手胜局 H 直胜局（只比较仅有两人同分的情况）
I 胜手和（所胜对手积分之和）；J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；
对手分方案：总分-A-C-D-E-F-H
*/ 	
//以序号为键值，重新构建数组	
$xss=array();
$zuidifen="no";
foreach ($xuanshous as $key => $value) {
	$xss[$value['xs_xuhao']]=$value;
	if ($zuidifen=="no"||$zuidifen>$value['xs_zongfen']) {
		$zuidifen=$value['xs_zongfen'];
	}
}
$_GET['konghaofen']?$konghaofen=$zuidifen:$konghaofen=0;  //可选择。konghaofen计算对手分时，空号的积分指定：本比赛所有选手的最低积分 或 零分
$yibaocunpaiming=$xuanshous[0]['xs_paiming']?1:0;//是否已经保存过排名了
$xuanshous='';
ksort($xss);
preg_match("/[\,\;\:]/",$bsinfo['bs_jufenmoshi'],$fengefu);
$fenzhis=split($fengefu[0],$bsinfo['bs_jufenmoshi']); 
//$shengfen=array($fenzhis[0],$fenzhis[3]);                     //胜方的得分，红的为【0】，黑方为【3】
$yinsus=str_split($_GET['paimingmoshi']);
	$zhulunfen=array();
	$zhulunshu=$bsinfo['bs_zonglunshu']-1;
	
	foreach ($xss as $xuhao => $xs) {
			$xianhous=str_split(trim($xss[$xuhao]['xs_xianhous'],','),1);  ///各轮的先后手序列
			$towhos=explode(',,',trim($xss[$xuhao]['xs_towhos'],','));     ///各轮的对手序列
			$fenshus=explode(',,',trim($xss[$xuhao]['xs_fenshus'],','));     //各轮的得分序列
			$gelunfens=array();                                              ///各轮的当轮积分（不是得分）序列
			foreach ($fenshus as $key => $value) {
				$gelunfens[]=array_sum(array_slice($fenshus,0,$key+1));
			}
			//////////////B 累进分//////////////////////
				$leijinfen=array_sum($gelunfens);             //最后累进分
			///////////////////////////////////
			
			/////////////C 胜局数、G 先手胜局、E 后手胜局、F 后手局数///////////
				$shengju=0;
				$xianshengju=0;
				$houshengju=0;
				$houshoushu=0;
				foreach ($fenshus as $key => $value) {
				    //if (($xianhous[$key]=='+'&&$value==$shengfen[0])||($xianhous[$key]=='-'&&$value==$shengfen[1])) {  //胜方
					if (($xianhous[$key]=='+'&&$value==$fenzhis[0])||($xianhous[$key]=='-'&&$value==$fenzhis[3])) {  //胜方
						$shengju++;
						if ($xianhous[$key]=="-") {  //后手胜
							$houshengju++;
						}else{ //先手胜
							$xianshengju++;
						}
					}
					if ($xianhous[$key]=="-") {
						$houshoushu++;
					}
				}
			///////////////////////////
			
			////////////////A 对手和（所遇对手对手分之和）、I 胜手和（所胜对手积分之和）；
			//J 和手和（所和对手积分之和）；K 负手和（所负对手积分之和）；/////////////////////
				$duishoufens=array();   ///所遇对手的总分 序列
				$shengshouhes=array();
				$heshouhes=array();
				$fushouhes=array();
				foreach ($towhos as $key => $value) {
					if ($value) {   
						$duishoufens[]=$xss[$value]['xs_zongfen'];
					}else{//对手序号为0，即对手为空号时的对手分
						$duishoufens[]=$konghaofen;
					}
					
					switch ($fenshus[$key].$xianhous[$key]){
						case $fenzhis[0].'+': //获胜（要求胜方的得分先后手一样）
						//$shengshouhes[]=$xss[$value]['xs_zongfen'];
						if ($value) {   
							$shengshouhes[]=$xss[$value]['xs_zongfen'];
						}else{//对手序号为0，即对手为空号时的对手分
							$shengshouhes[]=$konghaofen;
						}
							break;
						case $fenzhis[3].'-': //获胜（要求胜方的得分先后手一样）
						//$shengshouhes[]=$xss[$value]['xs_zongfen'];
						if ($value) {   
							$shengshouhes[]=$xss[$value]['xs_zongfen'];
						}else{//对手序号为0，即对手为空号时的对手分
							$shengshouhes[]=$konghaofen;
						}
							break;
						case $fenzhis[2].'+': //负
						//$fushouhes[]=$xss[$value]['xs_zongfen'];
						if ($value) {   
							$fushouhes[]=$xss[$value]['xs_zongfen'];
						}else{//对手序号为0，即对手为空号时的对手分
							$fushouhes[]=$konghaofen;
						}
						    break;
						case $fenzhis[4].'-': //负
						//$fushouhes[]=$xss[$value]['xs_zongfen'];
						if ($value) {   
							$fushouhes[]=$xss[$value]['xs_zongfen'];
						}else{//对手序号为0，即对手为空号时的对手分
							$fushouhes[]=$konghaofen;
						}
						    break;
						default:
						//$heshouhes[]=$xss[$value]['xs_zongfen'];
						if ($value) {   
							$heshouhes[]=$xss[$value]['xs_zongfen'];
						}else{//对手序号为0，即对手为空号时的对手分
							$heshouhes[]=$konghaofen;
						}
							break;
					}
				}
				$duishoufen=array_sum($duishoufens);  	  //对手和
				$shengshouhe=array_sum($shengshouhes);  //胜手和
				$heshouhe=array_sum($heshouhes);        //和手和
				$fushouhe=array_sum($fushouhes);        //负手和
			///////////////////////////////////
			  $xss[$xuhao]['towhos']=$towhos;
			  $xss[$xuhao]['xianhous']=$xianhous;       //取得每轮的先手手
			  $xss[$xuhao]['gelunfens']=$gelunfens;
			  $xss[$xuhao]['shengju']=$gelunfens;
				$a_zongfen[]=$xss[$xuhao]['xs_zongfen'];											//总分
                $xss[$xuhao]['duishoufen']=$a_duishoufen[]=$xss[$xuhao]['duishoufen']=$duishoufen;  					    //对手和 A
                $a_leijinfen[]=$xss[$xuhao]['leijinfen']=$leijinfen;      //最后累进分 B
				$a_shengju[]=$xss[$xuhao]['shengju']=$shengju;								//胜局数 C
				$a_fangui[]=$xss[$xuhao]['xs_fangui'];											//犯规 d
				$a_houshengju[]=$xss[$xuhao]['houshengju']=$houshengju;  						//后手胜局数 E
				$a_houshouju[]=$xss[$xuhao]['houshouju']=$houshoushu;  						//后手局数  F
				$a_xianshengju[]=$xss[$xuhao]['xianshengju']=$xianshengju;					//先手胜局数 G
			    //直胜局 h
				$a_shengshouhe[]=$xss[$xuhao]['shengshouhe']=$shengshouhe;    				//胜手和 I
				$a_heshouhe[]=$xss[$xuhao]['heshouhe']=$heshouhe;        					//和手和 J
				$a_fushouhe[]=$xss[$xuhao]['fushouhe']=$fushouhe;        					//负手和 K
	
				//以上任然不分高下，则去除一轮的得分再比，判断是对手分 或 累进分 ；去除从第一轮 还是 最后一轮开始
				//$_GET['dir']=1 从首轮开始去除；2 从尾轮开始去除
				$linshi=array();
				if ($yinsus[0]=='A') {  //对手分；默认 比较倒数第二轮积分，依此类推。
					$xiaofenmoshi='对<br />手<br />分';
					//$xss[$xuhao]['xiaofen']=$duishoufen;
					if ((!$_GET['dir'])||$_GET['dir']==2) {//2 从尾轮开始去除
						for($i=0;$i<$zhulunshu;$i++) {
							$linshi[]=array_sum(array_slice($fenshus,0,$zhulunshu-$i));
							//$linshi[]=0-$fenshus[$zhulunshu-$i];
						}	
					}else{  //1 从首轮开始去除；
						for($i=0;$i<$zhulunshu;$i++) {
							$linshi[]=array_sum(array_slice($fenshus,$i+1));
							//$linshi[]=0-$fenshus[$i];
						}	
					}
					foreach ($linshi as $jian => $zhi) {
						$zhulunfen[$jian][$xuhao]=$zhi;
					}					
				}else{  //累进分；
					$xiaofenmoshi='累<br />进<br />分';
					if ($yinsus[0]=='B') { 
						//$xss[$xuhao]['xiaofen']=$leijinfen;
						if ((!$_GET['dir'])||$_GET['dir']==1) {//1 扣除第一轮积分，比较之后的积分分，依此类推。//默认 
							for($i=0;$i<$zhulunshu;$i++) {
								$linshi[]=0-$fenshus[$i];
							}
						}else{ //2 从尾轮开始去除
							for($i=0;$i<$zhulunshu;$i++) {
								$linshi[]=0-$fenshus[$zhulunshu-$i];
							}
						}
				        foreach ($linshi as $jian => $zhi) {
							$zhulunfen[$jian][$xuhao]=$zhi;
						}
					}
				}
	}	
	//按指定的排名顺序来安排；例如：总分Z- ACDEFH
	$shunxu='';
	foreach ($yinsus as $key => $value) {
		switch ($value){
			case A:
			$shunxu.='$a_duishoufen,SORT_DESC,';	
				break;
			case B:
			$shunxu.='$a_leijinfen,SORT_DESC,';
			   break;
			case C:   //胜局数
			$shunxu.='$a_shengju,SORT_DESC,';
			   break;
			case D:   //犯规
			$shunxu.='$a_fangui,SORT_ASC,';
			   break;
			case E:   //后胜局
			$shunxu.='$a_houshengju,SORT_DESC,';
			   break;
			case F:   //后手局
			$shunxu.='$a_houshouju,SORT_DESC,';
			   break;
			case G:  //先胜局
			$shunxu.='$a_xianshengju,SORT_DESC,';
			   break;
			case H:
			/*暂时无法实现！！！！现在排序，跟前面的数组不对应了，不能再重排了！
			22比较，只个相同，直胜处理（相等或没遇过不理），赋值，xss排列
			$linshi2=$xss;
			$linshi='array_multisort($a_zongfen,SORT_DESC,'.$shunxu.'$xss);';
			eval($linshi);		
			foreach ($xss as $jian => $zhi) {
				
			}
			$shunxu.='$a_zhisheng,SORT_DESC,';*/
			   break;
			case I:
			$shunxu.='$a_shengshouhe,SORT_DESC,';
			   break;
			case J:
			$shunxu.='$a_heshouhe,SORT_DESC,';
			   break;
			case K:
			$shunxu.='$a_fushouhe,SORT_DESC,';
			   break;
			case Z:
			$shunxu.='$a_zongfen,SORT_DESC,';
			$youzongfen=1;
			   break;
			default:
				break;
		}
	}
	//上面任然没有分出高下时，进行去轮分的办法
	foreach ($zhulunfen as $key => $value) {
		$shunxu.='$zhulunfen['.$key.'],SORT_DESC,';
	}
//$shunxu='';
	if ($youzongfen) {  //有总分Z的破同分选项，主要是考虑牌类的比赛是先看胜局的，如CZA（仅仅是勉勉强强的！！
		$shunxu='array_multisort('.$shunxu.'$xss);';
	} else { //破同分选项中无Z的，即默认总分最先
		$shunxu='array_multisort($a_zongfen,SORT_DESC,'.$shunxu.'$xss);';
	}
	
//echo $shunxu;
	eval($shunxu);	
    
	$i=1;
	$mcsline='';
	foreach ($xss as $key => $value) {
		$xss[$key]['mingci']=$i;
		
		$mcsline.=$key?',':'';
		//$key?$mcsline.=',':'';
		$mcsline.=$xss[$key]['xs_id'].','.$xss[$key]['mingci'];
		$i++;
	}
	//echo $mcsline,$i,$i;exit;
			
//排序:////默认按序号从小到大；可选paixu=2 按排名从小到大
if ($_GET['paixu']) {
	switch ($_GET['paixu']){
		case 'xhabc':  //序号升序
		//ksort($xss);  //因为键值已经改变了！
		$xuhaos=array();
		foreach ($xss as $key => $value) {
			$xuhaos[]=$value['xs_xuhao'];
		}
		array_multisort($xuhaos,$xss);
			break;
		case 'xhcba':   //序号逆序、降序
		//krsort($xss);    //因为键值已经改变了！
		$xuhaos=array();
		foreach ($xss as $key => $value) {
			$xuhaos[]=$value['xs_xuhao'];
		}
		array_multisort($xuhaos,SORT_DESC,$xss);
			break;
		case 'pmabc':   //排名升序
		//array_multisort($a_zongfen,SORT_DESC,'.$shunxu.'$xss);
		//默认的，不用处理
			break;
		case 'pmcba':   //排名逆序、降序
		$xss=array_reverse($xss);
			break;
		case 'lunfen':   //指定轮的当轮积分，至当轮的对手分和，序号
		$lunfens=array();
		$xiaofens=array();
		if ($_GET['lunfenlun']&&is_numeric($_GET['lunfenlun'])) {
			$lunfenlun=ceil($_GET['lunfenlun']);
		}else{
			$lunfenlun=1;
		}
		foreach ($xss as $key => $value) {
			$lunfens[]=$value['gelunfens'][$lunfenlun-1];
			$xiaofens[]=array_sum(array_slice(explode(',,',trim($xss[$xuhao]['xs_fenshus'],',')),0,$lunfenlun));
		}
		ksort($xss);
		array_multisort($lunfens,SORT_DESC,$xiaofens,SORT_DESC,$xss);
		
			break;
		default:
			/*$paimings=array();
			foreach ($xss as $value) {
				$paimings[]=$value['paiming'];
			}
			array_multisort($paimings,$xss);*/
			break;
	}	
}

//取前几项显示////$qianji
if ($_GET['qianji']) {
	$xss=array_slice($xss,0,$_GET['qianji']);
}

//得分有小数的，积分、得分、总分、小分都要保留1位小数
if (round($fenzhis[1])!=$fenzhis[1]) {
	foreach ($xss as $key => $value) {
		//缺补一位小数
		ceil($xss[$key]['xs_zongfen'])==$xss[$key]['xs_zongfen']?$xss[$key]['xs_zongfen'].='.0':'';
		ceil($xss[$key]['xiaofen'])==$xss[$key]['xiaofen']?$xss[$key]['xiaofen'].='.0':'';
		foreach ($value['gelunfens'] as $lun => $jifen) {
			ceil($xss[$key]['gelunfens'][$lun])==$xss[$key]['gelunfens'][$lun]?$xss[$key]['gelunfens'][$lun].='.0':'';
		}
		/*if ($value['xs_xuhao']==4) {
			foreach ($value['gelunfens'] as $lun => $jifen) {
				ceil($xss[$key]['gelunfens'][$lun])?$xss[$key]['gelunfens'][$lun].='.0':'';
				echo $xss[$key]['gelunfens'][$lun];
				if (is_int($xss[$key]['gelunfens'][$lun])) {
					echo '<br>shi';
				}else{
					echo '<br>shi';
				}
			}
			echo $xss[$key]['gelunfens'][$lun];
			print_r($xss[$key]['gelunfens']);
		}*/
	}
}


?>