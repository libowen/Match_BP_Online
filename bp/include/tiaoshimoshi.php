
<?php
/**
 * 功能：调试模式的输出
 * 参数：状态 保存、编排
 * 返回：格式 状态#信息
 */
function tiaoshimoshi ($yemian,$kaiqi=1) {
	if ($_POST['tiaoshi']=='quancheng') {
		if ($yemian=='bianpai') {
			if ($_POST['tijiao']) {  //保存编排结果，输出 bpyicun和【duizhen序列】
				exit('bpyicun#'.$_POST['duizhen']);
			} else { //显示编排结果，输出 bpjieguo#【duizhen序列】
				if($GLOBALS['taicis']) {
						$duizhen='';
						for($i=0;$i<count($GLOBALS['taicis']);$i++) {
						  $red=$GLOBALS['taicis'][$i][0];
						  $black=$GLOBALS['taicis'][$i][1];
						  //验证下，因为是按台号来分的，可能对到的是空号（显示保存的编排结果，非编排）为空值
						  if (!$red) {
						  	$red['xs_xuhao']=0;
						  	$red['xs_name']='空号';
						  }
						  if (!$black) {
						  	$black['xs_xuhao']=0;
						  	$black['xs_name']='空号';
						  }					  
						  $duizhen.=$red['xs_xuhao'].','.$black['xs_xuhao'];
						  if($i<count($GLOBALS['taicis'])-1){ $duizhen.=','; }
						}
				} else {
					echo 'taicis为空！';
				}
				exit('bpjieguo#'.$duizhen.'#'.$GLOBALS['dijilun']);
			}	
		} elseif ($yemian=='dengfen') {
			if ($_POST['tijiao']) {
				if ($GLOBALS['fenshulun']>=$GLOBALS['bsinfo']['bs_zonglunshu']) {
					exit('bsjieshu');	//已登分的轮次等译比赛这顶的总轮次；但可能出现永远都到不了的情况！如15人14轮
				} else {
					exit('cjyicun');
				}
			}
		} elseif ($yemian=='GRcj') {
			if ($_POST['tijiao']) {
				exit('grpmyicun');
			} else {
				$mcsline='';
				foreach ($GLOBALS['xss'] as $key => $value) {
					$mcsline.=$value['xs_id'].','.($key+1);
					if ($key<count($GLOBALS['xss'])) {
						$mcsline.=',';
					}
				}
				$grpm_moshi=$GLOBALS['bsinfo']['bs_grpm_moshi'];
				exit('grpmjieguo#'.$mcsline.'#'.$grpm_moshi);
			}
		} elseif ($yemian=='TTcj') {
			//暂时用不上
		} else {
			exit('暂时没设定此页面的调试模式！');
		}
	}
}
?>