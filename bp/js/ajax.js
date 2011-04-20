


//建立通信xhr对象											 
function XHR(){	
			http_request = false;
				if (window.XMLHttpRequest) { 				//Mozilla等其他浏览器
					http_request = new XMLHttpRequest();
					if (http_request.overrideMimeType) {
						http_request.overrideMimeType("text/xml");
					}
				} else if (window.ActiveXObject) { 			//IE浏览器
					try {
						http_request = new ActiveXObject("Msxml2.XMLHTTP");
					} catch (e) {
						try {
							http_request = new ActiveXObject("Microsoft.XMLHTTP");
					   } catch (e) {}
					}
				}
				if (!http_request) {
					alert("不能创建XMLHTTP实例!");
					return false;
				}					 	
}

	          
 //函数对象集合
function a(method,url,shuju) {
//document.getElementById("safe").style.visibility="visible";	//也可换成提示“正在处理中”
//document.getElementById("callback_do").value=callback_do;
           XHR();
          if(http_request){
/*		       if(method==""){
                    method="GET";
// method='POST';url='http://localhost/luzhanqi/connect.php';shuju='';callbackMethod='callbackMethod';
                              }else{}
*/
					   if(method=="GET") {   //以GET方式提交数据
					   	   if ( url.match("?") ) { url+="&"; } else { url+="?";}
alert(url);
						   if ( shuju ) { url=url+"shuju="+shuju; }
//alert(url);==
						   http_request.open(method,url,true); 
						   http_request.onreadystatechange = callbackMethod;  
//   ToCallBack(http_request.responseText); 
						   http_request.send(null);
					   } else { //以POST方式提交数据	
   shuchu ('url=《'+url+'<br>shuju=《'+shuju);
						   http_request.open(method,url,true); 				   
			 			   http_request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						   http_request.onreadystatechange =callbackMethod;  
/*						   
http_request.onreadystatechange =function (){
callbackMethod("fanfan");
}*/
//   ToCallBack(http_request.responseText); 
						   http_request.send(shuju);
					   }				 
				  }
		     else{
				 alert('通信无法建立，请勿再试');
			 }	
}	
											

function callbackMethod(){
    if (http_request.readyState==4 && http_request.status==200) {
shuchu('通讯成功！'+bsid+'=bsid;dijilun='+dijilun+'<br>fanhuitext='+http_request.responseText);
    	tiaoshido(bsid,dijilun);
    } else {
		//通讯中显示 loading。。。。。。。。。
		//shuchu('通讯中显示 loading。。。。'+http_request.readyState+'。。。。。<br>');
	}	 
}


/**
 * 功能：在编排页面的全调试（推荐从首轮开始，中间开始也可以-需在编排中加入已保存编排时的）
 * 参数：bsid和dijilun
 */

function tiaoshi (thisdom,bsid,dijilun) {
	//document.getElementById("safeDiv").style.display="block";		
	safeDivOpen();			//开启安全层
	thisdom.disabled='disabled';       //防止多次点击
	bsid=bsid; 	 //主要是赋值到全局变量中
	if (dijilun) { dijilun=1; } else { dijilun=dijilun; }
	if (confirm("比赛结束后是否打开全部各个轮次的对阵表？")) { dakaiduizhen=1; }
	tiaoshido(bsid,dijilun);
}
dakaiduizhen=0;
qingqiucishu=1;
bsid=1;
dijilun=document.getElementsByName("lunci")[0].value;  //可以通过PHP修改起始值=$dijilun ！！如果在成绩页面得到的将是未知的！！
	function tiaoshido (bsidc,dijilunc) {
		bsid=bsidc;
		dijiun=dijilunc;
		if (qingqiucishu<=50) {
			if (typeof(http_request)!=='undefined') {
				qingqiucishu=1+qingqiucishu;
shuchu ('=请求次数'+qingqiucishu);
				fanhui=http_request.responseText.replace(/\s*/g,"");	//可以去除匹配任何空白字符，包括空格、制表符、换页符等等。等价于 [ \f\n\r\t\v]。
				fanhuis=fanhui.split('#');  //首个是状态值；后面的才是正文（如果没有#则没有正文）
				switch (fanhuis[0]) {
					//////bpyicun#【duizhen】序列
					case 'bpyicun':	//编排结果保存成功 》 进行提交本轮成绩（再返回cjyicun或bsjieshu）
						//shuju='duizhen=6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6&lunci='+dijilun;  // 提交本轮成绩
						shuju='tijiao=cjbaocun&tiaoshi=quancheng&duizhen='+fanhuis[1]+'&lunci='+dijilun;  // 提交本轮成绩
						//为了不提交数组，登分也做相应调整，chengji不定义也可以
						url="/bp/user/dengfen.php?bsid="+bsid;
						dijilun=1+Number(dijilun);
						a ("POST",url,shuju);				    
					  break;
					  
					case 'cjyicun':	//成绩保存成功 》 进行提交下轮编排结果，获取duizhen的值
						shuju='tiaoshi=quancheng';  	// 无需数据即可得到duizhen的
						url="/bp/user/bianpai.php?bsid="+bsid;
						a ("POST",url,shuju);
					  break;
					//////bpjieguo#【duizhen序列】
					case 'bpjieguo':   //获得编排结果》 将进行结果的保存
						//shuju='tiaoshi=quancheng&tijiao=baocunbianpai&tiaoshi=quancheng&duizhen=3,4,5,6,7,8,9,10&lunci='+dijilun;  // 非首次提交编排结果保存
						shuju='tiaoshi=quancheng&tijiao=baocunbianpai&duizhen='+fanhuis[1]+'&lunci='+dijilun;  // 多次提交编排结果
						
						url="/bp/user/bianpai.php?bsid="+bsid;
						a ("POST",url,shuju);
					  break;
					  
					case 'bsjieshu':	//整个比赛全部结束》获取个人排名
						shuju='tiaoshi=quancheng';
						url='/bp/zhibiao/GRcj.php?bsid='+bsid+'&moshi=1&paixu=pmabc&lunfenlun=&dir=1&qianji=&konghaofen=0';
						///上面应该是根据数据库内的数据变化的，GRpm中相应的没有传入值时默认使用数据库的配置！！
						a ("POST",url,shuju);
					  break;
					//////grpmjieguo#【个人排名序列】#【个人排名模式】
					case 'grpmjieguo':	//获取个人排名结果》提交保存个人排名
						shuju='tiaoshi=quancheng&tijiao=baocunpaiming&mcsline='+fanhuis[1]+'&grpm_moshi='+fanhuis[2];
						url='/bp/zhibiao/GRcj.php?bsid='+bsid;
						a ("POST",url,shuju);
					  break;
					  
					case 'grpmyicun':	//个人排名保存成功》将for在新窗口输出各轮次的对阵表、个人成绩表、团体成绩表
						//需要获取当前的dijilun-1???作为总轮数
						if (dakaiduizhen) {
							for (zonglunshu=dijilun-1;zonglunshu>0;zonglunshu--) {  ///循环打开各个轮次的对阵表
								url='/bp/zhibiao/bpjilu.php?moshi=2&bsid='+bsid+'&dijilun='+zonglunshu;
								newname='di'+zonglunshu+'lun';
								window.open (url,newname);					
							}
						}
						///个人成绩详细表
						window.open('/bp/zhibiao/GRcj.php?bsid='+bsid+'&moshi=1&paixu=pmabc&lunfenlun=&dir=1&qianji=&konghaofen=0');
					    ///团体成绩详细表
						//window.open('/bp/zhibiao/TTmc.php?bsid='+bsid+'&duiyuanshu=4&chuque=0&momingci=&qianji=');
					  	window.open('/bp/zhibiao/TTcj.php?bsid='+bsid+'&duiyuanshu=&chuque=0&momingci=&qianji=');
					  	
						document.getElementById("safeDiv").style.display="none";	//关闭安全层
						alert("恭喜你，你已经完成整个比赛的编排和成绩录入、排名保存！");
					  break;
					  
					default:	//可能为空 或 其他出错提示 或 权限不够的提示
					document.getElementById("safeDiv").style.display="none";	//关闭安全层
					alert("没有完成整个比赛！一般是选手数太接近总轮数了 或 比赛配置信息非常规");
						//shuchu('text='+http_request.responseText+'=text');  //alert("可能出错或权限不够！"+http_request.responseText);
					  break;
				}
				
			} else {
shuchu ('首次请求。');
				//首次提交数据，此为编排结果
				shuju='tiaoshi=quancheng&tijiao=bpbaocun&duizhen='+document.getElementsByName("duizhen")[0].value+'&lunci='+document.getElementsByName("lunci")[0].value; 
				url="/bp/user/bianpai.php?bsid="+bsid;
				a ("POST",url,shuju);
			}
		} else {
			document.getElementById("safeDiv").style.display="none";	//关闭安全层
			alert("没有完成整个比赛！超过了系统设定的请求次数，请刷新后继续点击调试（也可能是数据问题）");
		}
	}

	////临时过程输出
	function shuchu (xinxi) {
		if (1) {   ///选择写入那个div中
			if (document.getElementById('shuchu')) {
				document.getElementById('shuchu').innerHTML+='<br>'+xinxi+'》<br>';
			} else {
				newDiv=document.createElement('div');
				newDiv.setAttribute('id','shuchu');
				newDiv.style.display='none';
					newDiv.setAttribute('display','none');
				newDiv.style.hetght='100px';
				document.body.appendChild(newDiv);
				document.getElementById('shuchu').innerHTML+='<br>'+xinxi+'';
			}
		} else {
			document.getElementById('safeDiv').innerHTML+='<br>'+xinxi+'》<br>';
		}
	}

	//开启安全层
	function safeDivOpen () {
		safeDivDom=document.getElementById('safeDiv');
		//safeDivDom.style.width = document.body.scrollWidth;
		//safeDivDom.style.height = document.body.scrollHeight>document.body.clientHeight?document.body.scrollHeight:document.body.clientHeight;
		pageDimensions = getPageSize(); 
		safeDivDom.style.height = String(pageDimensions[0])+"px";
		safeDivDom.style.width = String(pageDimensions[1])+"px";
		safeDivDom.style.display='block';
//alert(safeDivDom.style.height);
	}
	
	//跨浏览器取得当前页面的高度的解决方法
	function getPageSize()
	{
		if (document.documentElement.clientHeight) {  //IE6和IE8的临时兼容，某些情况可能还不正确！
			bodyDom=document.documentElement;
		} else {
			bodyDom=document.body;
		}
		var bodyOffsetWidth = 0;
		var bodyOffsetHeight = 0;
		var bodyScrollWidth = 0;
		var bodyScrollHeight = 0;
		var pageDimensions = [0,0];
		pageDimensions[0]=bodyDom.clientHeight;
		pageDimensions[1]=bodyDom.clientWidth;
		bodyOffsetWidth=bodyDom.offsetWidth;
		bodyOffsetHeight=bodyDom.offsetHeight;
		bodyScrollWidth=bodyDom.scrollWidth;
		bodyScrollHeight=bodyDom.scrollHeight;
		if(bodyOffsetHeight > pageDimensions[0]) {
			pageDimensions[0]=bodyOffsetHeight;
		}
		if(bodyOffsetWidth > pageDimensions[1]) {
			pageDimensions[1]=bodyOffsetWidth;
		}
		if(bodyScrollHeight > pageDimensions[0]) {
			pageDimensions[0]=bodyScrollHeight;
		}
		if(bodyScrollWidth > pageDimensions[1]) {
			pageDimensions[1]=bodyScrollWidth;
		}
		return pageDimensions;
	} 