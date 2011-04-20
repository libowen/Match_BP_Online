
//获取location.href的值，并修改其中的get某个参数的数值（只数字），实现跳转【如果没有指定canshu则新增】
function goToNewUrl(canshu,shuzhi,target,thisdom) {
	if (thisdom&&thisdom.value) {
		shuzhi=thisdom.value;
	}
	if (canshu.indexOf('=')<0) {
		canshu=canshu.concat('=');  // 保证参数后都带有=号
	}
	urls=location.href.split(canshu);
	if (typeof(urls[1])=='undefined') {//不存在指定的canshu，则新增
		urls[1]='';
		canshu='&'.concat(canshu);
	}
	weizhi=urls[1].indexOf('&');		
	if (weizhi<0) {
		bsid=urls[1]; 						//如果是最后一个参数，直接赋值即可
		urls[1]='';
	} else {
		bsid=urls[1].slice(0,weizhi);    	//从 start 开始（包括 start）到 end 结束（不包括 end）为止的所有字符。
		urls[1]=urls[1].slice(weizhi);
	}
	if (!bsid) { bsid=0; } else { bsid=Number(bsid); }				//如果参数=号后为空，默认为0	
//alert(bsid);
	if (shuzhi.charAt(0)=='+') {
		newbsid=bsid+Number(shuzhi.slice(1));
	} else if (shuzhi.charAt(0)=='-') {
		newbsid=bsid-Number(shuzhi.slice(1));
	} else if (!isNaN(shuzhi)) {	//是数值
		newbsid=shuzhi;
	} else {
		//提示错误，并结束		！似乎不能实现！
		alert('指定的数据不是数值！');
		return false;
	}
//alert(thisdom.value);
	newurl=urls[0].concat(canshu).concat(newbsid).concat(urls[1]);
	if (target) {//在新窗口打开
		open(newurl);
	} else {//原窗口打开
		location.href=newurl;
	}
}