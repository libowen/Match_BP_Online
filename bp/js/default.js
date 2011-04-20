//新窗口打开选手详细信息页面，可以查看修改指定选手的信息
function gotoxs(xsbsid,xsxuhao,thisdom) {
		if (thisdom) {   //优先这个，value替换xsxuhao
			xsxuhao=thisdom.value;
		}
		url="/bp/user/xuanshou.php?bsid=".concat(xsbsid).concat("&xsxuhao=").concat(xsxuhao);
//alert(url);
		window.open(url);
//		location.href=url;
}

//////////////////////////////////////////////
/*function fenye(tiaoshu=16){
	
	zhizhangDOMs=document.getElementsByName('A4');
	alert(zhizhangDOMs[0].innerHTML);
	//tabledoms=document.getElementsByTagName('table');
	//trdoms=tabledoms[i].getElementsByTagName('tr');
	contentDOMs=document.getElementsByName('content');
}
*/

/* 暂时不知有什么用，而且下面可能有IE6不兼容的代码！IE6老提示object expected；
另外，删除转换编码出现的特殊首字符前出现expected identifier 代码 0
function trcolor(trDOM){
	trDOM.style.backgroundColor="blue";
	alert('bian');
}

function tt(){
	tabledoms=document.getElementsByTagName('table');
	for(i=0;i<tabledoms.length;i++){
		if(tabledoms[i].class='Lbianpai'){
			alert('ddd');
			trdoms=tabledoms[i].getElementsByTagName('tr');
			for(i=0;i<trdoms.length;i++){
				trdoms[i].title='dfjekjejk';
				trdoms[i].onclick="trcolor(this)";
				trdoms[i].setAttribute('onclick',"trcolor(this)");
				//alert('');
			}		
		}
	}

	
	//document.getElementById('form').onclick="trcolor(this)";
	
	alert(tabledoms[0].innerHTML);
}
//onloaded=tt();

*/
