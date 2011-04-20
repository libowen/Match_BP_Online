<?php
/**
* FILE_NAME : class_bianpai.php   FILE_PATH : F:\PHPnow\htdocs\bianpai2\class\class_bianpai.php
*  由于编排的代码和实现比较复杂，所以分多步进行class BP
									fun：diyilun第一轮
									fun：ersilun第二轮?倒数第四轮
									fun：housanlun最后三轮
									fun：zuihoulun最后一轮
									    fun：qianfd 第一分段和中间分段
									       fun：yipei各分段的第一次配（先判断是否有上分段余项）
									       fun：erpei非最后一分段有余量>1时，拆到余<2或本分段完
									           Fun：chai逐一向上拆对配对，也逐一得到方案
									fun：zuihoufd最后一分段
									     fun：erpei2最后一分段有余量>0时，一直拆到无余！！
*
* @copyright Copyright (c) 2010
* @author baiwen开发
* @version Mon Feb 01 14:27:59 CST 2010
*/

/**
 * 功能：指定比赛编排的实现，fun：diyilun第一轮；ersilun第二轮?倒数第四轮；housanlun最后三轮；zuihoulun最后一轮
 * 需要考虑的全局参数： SXtiao；Jliansan；TTbuyu  不连三不一定不多三
   chafengaoping;		//后三轮：（默认值0：不考虑，>0才进行）配对后，优先平衡相差？分和？分
    考虑去除退出比赛的选手，考虑分制：1：0.5：0.5：0，保存还要考虑弃权的情况，判断超过x次不进行编排
 */
class BP{
      /**
	  * 功能：编排第一轮的处理：5种配对方式，10种先后手安排方式（正规组合：3【拦腰】，2【单台小号先】/6【单台小号后】；娱乐组合：1【临近】，2【单台小先】/6【单台小后】）
	  * 参数：$peidui=1-4，配对的方式，默认为3; $chengyuan按序号排列的选手列表$chengyuan[xs_xuhao]；$xianhou 第一轮先后手的决定方式。
	  * 返回：$taici配对好的数据，默认小号在前，即[0]先手
	  */
	   public function diyilun($chengyuan,$peidui=3,$xianhou=2){
	      require_once(CLASS_PATH."diyilun.php");
	      //已经在筛选中以序号排序了
	      return diyilun($chengyuan,$peidui,$xianhou);
	   }


		/**
		* 功能：第二轮至倒数第四轮的编排
		* 参数：$chengyuan 数据库中获取的以编号顺序的的数组；$saizhi 具体的赛制和编排方式：是否考虑平衡先后手，是否支持连三；$tiao 是否考虑上下调的次数：考虑，不考虑，考虑连二；
		* 返回：配对好的 2维+多维数组
		*/
		public function ersilun($chengyuan,$saizhi=1){
	      require_once(CLASS_PATH."ersilun.php");
	      return ersilun($chengyuan,$saizhi,$xianhou);
		}

		
		/**
		* 功能：最后三轮的编排
		* 参数：$chengyuan 数据库中获取的以编号顺序的的数组；$saizhi 具体的赛制和编排方式：是否考虑平衡先后手，是否支持连三；$tiao 是否考虑上下调的次数：考虑，不考虑，考虑连二；
		* 返回：配对好的 2维+多维数组
		*/
		public function housanlun($chengyuan,$saizhi=1){
	      require_once(CLASS_PATH."housanlun.php");
	      return housanlun($chengyuan,$peidui,$xianhou);
		}
		
		/**
		* 功能：最后一轮的编排
		* 参数：$chengyuan 数据库中获取的以编号顺序的的数组；$saizhi 具体的赛制和编排方式：是否考虑平衡先后手，是否支持连三；$tiao 是否考虑上下调的次数：考虑，不考虑，考虑连二；
		* 返回：配对好的 2维+多维数组
		*/
		public function zuihoulun($chengyuan,$saizhi=1){
	      require_once(CLASS_PATH."zuihoulun.php");
	      return zuihoulun($chengyuan,$peidui,$xianhou);
		}
	
	
}

?>