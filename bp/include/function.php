<?php 


/**
* 功能：计算已经登过成绩的轮数，以选手中towhos最多的为准，并取出所获取的那个选手的键值
* 参数：选手数组
* 返回：登过成绩的轮数[0] 和 取出所获取的那个选手的键值[1]
*/
function fenshulun($xuanshous) {
		$zuiduokey=$zuiduoshu=0;
			foreach ($xuanshous as $key => $value) { 	//寻找fenshus个数最多的项，
				if (substr_count($value['xs_fenshus'],',')>$zuiduoshu) {
					$zuiduoshu=substr_count($value['xs_fenshus'],',');
					$zuiduokey=$key;
				}
			}
		$fenshulun=substr_count($xuanshous[$zuiduokey]['xs_fenshus'],',')/2;     //当前已经录入成绩的轮数
		$fanhui=array();
		$fanhui[0]=$fenshulun;
		$fanhui[1]=$zuiduokey;
		return $fanhui;
}

/**
* 功能：计算已经保存过编排结果的轮数，以选手中towhos最多的为准，并取出所获取的那个选手的键值
* 参数：选手数组
* 返回：保存过编排结果的轮数[0] 和 标准项的键值[1]
*/
function bianpailun($xuanshous) {
		$zuiduokey=$zuiduoshu=0;
		foreach ($xuanshous as $key => $value) { 	//寻找towhos个数最多的项，
			if (substr_count($value['xs_towhos'],',')>$zuiduoshu) {
				$zuiduoshu=substr_count($value['xs_towhos'],',');
				$zuiduokey=$key;
			}
		}
		$dijilun=substr_count($xuanshous[$zuiduokey]['xs_towhos'],',')/2;        //当前已经编排和保存编排结果的轮数
		$fanhui=array();
		$fanhui[0]=$dijilun;
		$fanhui[1]=$zuiduokey;
		return $fanhui;
}


/**
* 功能：获取前若干轮次的选手配对和成绩数据，即截至轮次（含）前的数据
* 参数：选手数组 $xuanshous ;指定要获取的轮数 $lunshu; 是否保留当轮的成绩 $chengji
* 返回：截至轮次（含）前的数据的选手数组
*/
function anlunhuoqu($xuanshous,$lunshu,$cjliu=1) {
	if ($lunshu !== '') {		
		//首先撤销当前轮次的编排结果，注意前面轮次成绩的保留
	    $lun = $lunshu;						//保留前 多少轮的编排结果，
		$cjliu = $cjliu ? $cjliu : 0;				//保留前面轮次的成绩 1 
		if ($lun) {
			foreach ($xuanshous as $key => $value) {
			    try {
					$fenshus=array_slice(explode(',,',trim($value['xs_fenshus'],',')),0,$lun-abs($cjliu-1));
					 //$lianqis=array_slice(explode(',,',trim($value['xs_lianqis'],',')),0,$lun-abs($cjliu-1));
					$lianqis=array_slice(str_split(trim($value['xs_lianqis'],' '),1),0,$lun-abs($cjliu-1));
					$zongfen=array_sum($fenshus);
					$taihaos=array_slice(explode(',,',trim($value['xs_taihaos'],',')),0,$lun);
					$towhos=array_slice(explode(',,',trim($value['xs_towhos'],',')),0,$lun);
					$xianhous=array_slice(str_split(trim($value['xs_xianhous'],' '),1),0,$lun);
					$shangxias=array_slice(str_split(trim($value['xs_shangxias'],' '),1),0,$lun);

				}catch (Exception $e){
					echo '选手序号：【',$xuanshous[$key]['xs_xuhao'],'】恢复后将产生错误！';
					echo '<br>原始数据：fenshus=',$xuanshous[$key]['xs_fenshus'],';taihaos=',$$xuanshous[$key]['xs_taihaos'];
					echo ';<br>towhos=',$xuanshous[$key]['xs_towhos'],';<br>xianhous=',$xuanshous[$key]['xs_xianhous'];
					echo ';<br>zongfen=',$xuanshous[$key]['xs_zongfen'];	
					exit('恢复后不符合规范！');
				}				
				empty($fenshus)?$xuanshous[$key]['xs_fenshus']='':$xuanshous[$key]['xs_fenshus']=','.join(',,',$fenshus).',';
				 empty($lianqis)?$xuanshous[$key]['xs_lianqis']='':$xuanshous[$key]['xs_lianqis']=join('',$lianqis);
				$xuanshous[$key]['xs_taihaos']=','.join(',,',$taihaos).',';
				$xuanshous[$key]['xs_towhos']=','.join(',,',$towhos).',';
				$xuanshous[$key]['xs_xianhous']=join($xianhous);
				$xuanshous[$key]['xs_zongfen']=$zongfen;		
				$xuanshous[$key]['xs_shangxias']=join($shangxias);
			}	
		} else {
			foreach ($xuanshous as $key => $value) {
				$xuanshous[$key]['xs_fenshus']='';
				 $xuanshous[$key]['xs_lianqis']='';
				$xuanshous[$key]['xs_taihaos']='';
				$xuanshous[$key]['xs_towhos']='';
				$xuanshous[$key]['xs_xianhous']='';
				$xuanshous[$key]['xs_zongfen']='0';
				$xuanshous[$key]['xs_shangxias']='';							
			}
		}
		return $xuanshous;
	} else {//至少应为一轮，否则全部显示
		return $xuanshous;
	}
}
?>



