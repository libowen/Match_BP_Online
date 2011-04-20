




/*
 *功能：查看时，列的背景色，根据其id来判断是影响哪些列的
 *参数：颜色值填写input text的引用
 */
function liefuse(thisDOM){
		yanse=thisDOM.value;
		if(yanse&&yanse.length>2){
			if(yanse=="suiji"){
				sezus=new Array("#FF66FF","#CC9999","#FF9999","#CCFF00","#00FF00","#66FF00","#FFFF00","#99FF00");
				key=Math.floor(Math.random()*8);
				yanse=sezus[key];
			}
		}else{
				yanse="";
		}
	towho=thisDOM.getAttribute("id");
	if(towho=="xianshou"|| towho=="houshou"|| towho=="jifen"|| towho=="zongfen"|| towho=="paiming")
	{
	}else{
		switch(towho){
			case "xiansezhi":
			towho="xianshou";
			break;
			case "housezhi":
			towho="houshou";
			break;
			case "fensezhi":
			towho="jifen";
			break;
			//待续
		}
	}
	
	towho="."+towho;
	changecss(towho,"backgroundColor",yanse);
//alert(yanse);
}




/*
 *功能：查看时，是否启用行标注的复选；去勾可清除所有已标注行的背景色；勾选才能左击添色，右击去色。
 *参数：复选框引用
 */
function DOhangbiaozhu(thisDOM){
	if(thisDOM.value>0){  //之前是大于0的，启动的；现在进行清除相关背景色，并关闭
		thisDOM.value=0;
		
		trneeds=getDom("tr","class","hang");
		for(i=0;i<trneeds.length;i++){
			if(trneeds[i].style.backgroundColor){
		        trneeds[i].style.backgroundColor='';
			}
		}
		
	}else{   //启用
		thisDOM.value=1;
	}
}


/*  ！！！未完成的！！！！！！！
 *功能：查看时，自动适应宽度，主要针对横式A4纸张的显示过宽
 *参数：复选框引用
 */
function zishikuan(thisDOM){

	if(thisDOM.value>0){  //关闭
		thisDOM.value=0;
		

		
	}else{  //启用
		thisDOM.value=1;
		
		
		/////暂时方案：只移动滚动条
		zhiding=118;
		if (document.documentElement){ 
			document.documentElement.scrollLeft=zhiding;
		} else if (document.body) { 
			document.body.scrollLeft=zhiding;
		} 	
		
		////未来方案：引用全新的样式表		
		
	}
}



/*
 *功能：查看时，单击行改变背景色
 *参数：行的引用；moshi=1 单击上色，moshi=2 双击消除背景色
 *备注：需开启；先检查是否允许行标注；tr为class=hang的onclick；主要是改变tr的背景颜色
 */
function trbiaozhu(trDOM,moshi){
	if(moshi==2){
		trDOM.style.backgroundColor="";
	}else{
		if(document.getElementById("hangbiaozhu").value>0){
			hangyanse=document.getElementById("hangsezhi").value;
			if(hangyanse&&hangyanse.length>2){
				if(hangyanse=="suiji"){
					sezus=new Array("#FF66FF","#CC9999","#FF9999","#CCFF00","#00FF00","#66FF00","#FFFF00","#99FF00");
					key=Math.floor(Math.random()*8);
					hangyanse=sezus[key];
				}
				trDOM.style.backgroundColor=hangyanse;
	//alert(hangyanse);
			}else{
				trDOM.style.backgroundColor="#66FF00";
			}
	//alert("kai");
		}
	}
}



/*
 *功能：向上翻一页或向下翻一页；以屏幕为标准
 *参数：方向  上页<=0；下页>0
 *备注：不知FF和IE能否兼容？
 */
function fanye(fangxiang){
	//滚动一张纸的高度
	A4DOMs=getDom("div","class","A4H");
	//A4纸横式的高度210mm=798（FF是797）；竖式的297mm=1129；
	if(A4DOMs){ bianhua=798; }else{ bianhua=1129; }
	A4DOMs='';
	if(fangxiang<1){ bianhua=0-bianhua; }
	
	if (document.documentElement){ 
		yScroll = document.documentElement.scrollTop; 
		document.documentElement.scrollTop=yScroll+bianhua;
	} else if (document.body) { 
		yScroll = document.body.scrollTop; 
		document.body.scrollTop=yScroll+bianhua;
	} 	
}



/*
 *功能：跳转到指定页面，以页码为标准
 *备注：IE可以实现。不过似乎FF之引入了文件名，前面的路径没有了！
 */
function yematiaozhuan(){
	yemahao=Math.floor(document.getElementById("tiaozhiyema").value);
	if(yemahao>0){
		 location.href="#".concat(yemahao);
//alert(yemahao);
	}else{
	     location.href="#maotop";
	}
}


/*
 *功能：内容修改（包括：打印时间、比赛时间、比赛地点、比赛组别）
 */
function neirongxiugai(){
	dyshijian=document.getElementById("printtime").value;
	bsshijian=document.getElementById("bisaishijian").value;
	bsdidian=document.getElementById("bisaididian").value;
	bszubie=document.getElementById("bisaizubie").value;
	yemaqu=document.getElementById("yemaquyu").value;
	if(dyshijian&&dyshijian!="打印时间："){
		if(dyshijian=="打印时间：now"||dyshijian=="打印时间：xianzai"||dyshijian=="muqian"||
		   dyshijian=="打印时间：现在"||dyshijian=="打印时间：当前"||dyshijian=="打印时间：今时"||
		   dyshijian=="打印时间：现在时间"||dyshijian=="打印时间：当前时间"){
			xianzai=new Date();
//dyshijian="打印时间："+xianzai.getYear()+"年"+(xianzai.getMonth()+1)+"月"+xianzai.getDate()+"日 "+xianzai.getHours()+':'+xianzai.getMinutes()+':'+xianzai.getSeconds();	
				dyshijian="打印时间："+xianzai.toLocaleString();
		}
		linshi=getDom("div","class","printtime");	
		if(linshi){
			for(i=0;i<linshi.length;i++){
				linshi[i].innerHTML=dyshijian;
			}
		}
	}
	if(bsshijian&&bsshijian!="比赛时间："){
		linshi=getDom("div","class","bisaishijian");
		if(linshi){
			for(i=0;i<linshi.length;i++){
				linshi[i].innerHTML=bsshijian;
			}
		}
	}
	if(bsdidian&&bsdidian!="比赛地点："){
		linshi=getDom("div","class","bisaididian");
		if(linshi){
			for(i=0;i<linshi.length;i++){
				linshi[i].innerHTML=bsdidian;
			}
		}
	}
	if(bszubie&&bszubie!="比赛组别："&&bszubie!="组别："){
		linshi=getDom("div","class","bisaizubie");
		if(linshi){
			for(i=0;i<linshi.length;i++){
				linshi[i].innerHTML=bszubie;
			}
		}
	}
	if(yemaqu&&yemaqu!="页码："){
		linshi=getDom("div","class","yemaquyu");
		if(linshi){
			for(i=0;i<linshi.length;i++){
				linshi[i].innerHTML=yemaqu;
			}
		}
	}
}

/*
 *功能：打印预设；包括字体大小设置、分页、指定显示、引用外部样式表
 */
function dayinyushe(){
	document.getElementById("gongju").style.display="none";
	font_size=Math.floor(document.getElementById("zitidaxiao").value);
	if(font_size&&font_size!="NaN"){
		font_size=String(font_size)+"px";
		changecss("a, td, th, input, select","fontSize",font_size); //功能：打印预设之字体大小设置
		//IE的不能用逗号分开的，这样也是逐个取；且A/TD/TH/INPUT/SELECT 等都必定大写
		//ff的唯实际书写为准，逗号不拆开但后面必须跟个空号！！无论实际是否有
	}
	
	fenye();  						//按条件分页，默认20条每页
	
	zhidingxianshi();   			//只显示的页面范围
	
	//是否启用行，对手背景色（含每轮积分的）；
	hang=document.getElementById("fusexuanranH").value;
	meilun=document.getElementById("fusexuanranD").value;
	if(hang){
		changecss(".hang","backgroundColor","red","print");
	}
	if(meilun){
	    changecss(".xianshou","backgroundColor","red","print");
		changecss(".houshou","backgroundColor","red","print");
		changecss(".jifen","backgroundColor","red","print");
	}
//changecss(".jifen","color","red","print");
	document.getElementById("gongju").style.display="block";
}


/*
 *功能：打印预设之分页
 */
function fenye(){
			//设定每张A4纸的高度。A4H横式；A4S竖式；
			changecss(".A4H","height","210mm");
			changecss(".A4S","height","297mm");
			
	//tiaoshu=tiaoshu;设置获取分页条件：每页的条数
	tiaoshu=document.getElementById("meiyetiaoshu").value;
	if(tiaoshu){//为空不处理
			
			///获取所有的数据tr的行///
			trneeds=getDom('tr','class','hang');
			
			yeshu=Math.ceil(trneeds.length/tiaoshu);   			///获取按新条数重新排列后需要的纸张数
			try{document.getElementById("yezongshu").value=yeshu;}catch(e){}


			///删除所有的数据tr，以便于后面获取空壳///
			for(i=0;i<trneeds.length;i++){
				//parentD.removeChild(trneeds[i]);
				trneeds[i].parentNode.removeChild(trneeds[i]);
			}
			
			///获取当前（旧的）所有的纸张DOM，实际只是使用第一个即可///
			A4DOMs=getDom('div','class','A4H');
			if (!A4DOMs[0]) { A4DOMs=getDom('div','class','A4S'); }
			
			divKING=A4DOMs[0].parentNode; 					///获取纸张所在的列表DOM///		
			cloneDOM=A4DOMs[0].cloneNode(true);     		///保留一个纸张空壳，以便
//alert(cloneDOM.innerHTML);
			///删除旧纸张列表里的内容///
			for(i=0;i<A4DOMs.length;i++){	
			    A4D=divKING.removeChild(A4DOMs[i]);
			}
//alert(yeshu);			
			///把纸张空壳追加进纸张列表中///
			for(i=0;i<yeshu;i++){
				cloneD=cloneDOM.cloneNode(true);
				divKING.appendChild(cloneD);
			}
			
			///追加纸张后，最新的纸张DOMs、yemaDOMs、和timeDOMs///
			ge=ge1=ge2=0;
			A4DOMs=getDom('div','class','A4H');
			if (!A4DOMs[0]) { A4DOMs=getDom('div','class','A4S'); }
			yemaDOMs=getDom('div','class','yemaquyu');
			timeDOMs=getDom('div','class','printtime');
			maoDOMs=getDom("a","class","maodian");
			for(i=1;i<=yemaDOMs.length;i++){
				yemaDOMs[i-1].innerHTML="第 "+i+" 页（共 "+yeshu+" 页）";
			}
			for(i=1;i<=timeDOMs.length;i++){
				//dyshijian=""+xianzai.getYear()+"年"+(xianzai.getMonth()+1)+"月"+xianzai.getDate()+"日 "+xianzai.getHours()+':'+xianzai.getMinutes()+':'+xianzai.getSeconds();	
				//timeDOMs[i-1].innerHTML=dyshijian;
			}
			for(i=1;i<=maoDOMs.length;i++){
				maoDOMs[i-1].setAttribute("name",i);
				maoDOMs[i-1].setAttribute("id",i);
			}
			
			///最新的shujutables，即纸张更新后的///
			shujutables=getDom("table","class","shujutable");
			
			///判断是IE浏览器还是FF浏览器，其实有更直接的方法，不过不知效果如何///
			try{
				if(shujutables[0].childNodes[0].tagName){
					//alert(shujutables[0].childNodes[0].childNodes[0].tagName);
					liulanqi="ie";
				}else{
					//alert(shujutables[0].childNodes[1].childNodes[0].tagName);//获取到的是TR才对
					liulanqi="ff";
				}
			}catch(e){
			    //alert('linglei='+shujutables[0].childNodes[1].childNodes[1].tagName);
			}
//alert(liulanqi);
//alert(trneeds.length);
//alert(shujutables.length);
//alert(shujutables[0].childNodes[1]);
			///按条数分配数据到各纸张中///
			yehao=1;
			for(i=0;i<trneeds.length;i++){
				if(i>=yehao*tiaoshu){
					yehao++;
				}
				if(liulanqi=="ie"){
					shujutables[yehao-1].childNodes[0].appendChild(trneeds[i]);
				}else{
					shujutables[yehao-1].childNodes[1].appendChild(trneeds[i]);
				}
			}
	}
}

/*
 *功能：打印预设之指定显示
 *备注：从1开始
 */
function zhidingxianshi(){
	qian=Math.floor(document.getElementById("xianshiyema1").value);
	hou=Math.floor(document.getElementById("xianshiyema2").value);
//qian=(qian&&qian!="NaN")?qian;'';//无法成立
	if((!qian)||qian=="NaN"){ qian=""; }
	if((!hou)||hou=="NaN"){ hou=""; }
	//获取纸张的DOMs
	A4DOMs=getDom("div","class","A4H");
	if(!A4DOMs[0]){ A4DOMs=getDom("div","class","A4S"); }
	
	if(qian&&hou){
		if(qian>hou){
			linshi=qian;
			qian=hou;
			hou=linshi;
		}		
	}else{
		if(hou){ qian=hou; }else{ hou=qian; }
	}
	if(qian||hou){
		for(i=1;i<=A4DOMs.length;i++){
			if(i>=qian&&i<=hou){
				A4DOMs[i-1].style.display="block";
			}else{
				A4DOMs[i-1].style.display="none";
			}
		}
	}
//alert(qian+'hh'+hou);
}

/*
 *功能：引入自定义外部样式表css文件
 *备注：IE可以实现。不过似乎FF之引入了文件名，前面的路径没有了！
 */
function yinrucss(){
	cssfile=document.getElementById("waibucss").value;
		//cssfile=document.getElementById("waibucss").innerHTML;
	if(cssfile){
		//清除其他样式信息
		styles=document.getElementsByTagName("style");
		links=document.getElementsByTagName("link");
		for(i=0;i<styles.length;i++){
			styles[i].parentNode.removeChild(styles[i]);
		}
		for(i=0;i<links.length;i++){
			links[i].parentNode.removeChild(links[i]);
		}
alert(cssfile);
		//载入新的样式信息即外部样式表
		newlink=document.createElement("link");
		newlink.href=cssfile;
		newlink.setAttribute("rel","stylesheet");
		newlink.setAttribute("type","text/css");
		firsthead=document.getElementsByTagName("head")[0];
		firsthead.appendChild(newlink);
	}
}





/*
 *功能：公用函数 yixia
 */
 
 /*
 *功能：修改css样式表中的属性值
 *参数：theCSS={前的字段即样式选择符（如是多个，道号后有空格）；element属性名；value属性值；media不空时将只修改相应的输出样式
 *备注：（这里只兼容了标签前无其他选择器的；和有逗号的情况）
 */
function changecss(theClass,element,value,media) {
//IE的不能用逗号分开的，这样也是逐个取；(好像凡是标签都是大写，无论实际写的是小写和前面已有.classname）
//ff的唯实际书写为准，逗号不拆开但后面必须跟个空号！！无论实际是否有
//这里只兼容了标签前无其他选择器的
	if(document.all&&theClass.indexOf(",")!=-1){
	   var linshi=new Array();
	   linshi=theClass.split(", ");  //必须是带一个空格！FF和IE都需要
	   for(i=0;i<linshi.length;i++){
		   changecss(linshi[i],element,value);
	   }
	}else{
		var cssRules;
		if (document.all) {//IE
		   cssRules = 'rules';
		   if (theClass=="a"||
			   theClass=="talbe"||
			   theClass=="td"||
			   theClass=="th"||
			   theClass=="tr"||
			   theClass=="input"||
			   theClass=="div"||
			   theClass=="select"){ //另外的还未知。转换成大写
				   theClass=theClass.toLocaleUpperCase();
		   }
		}
		else if (document.getElementById) { //FF
		   cssRules = 'cssRules';
		}
		
		for (var S = 0; S < document.styleSheets.length; S++){
			   if((!media)||document.styleSheets[S].title==media){//只是想修改打印样式里的属性
//alert(document.styleSheets[S].title);
				   for (var R = 0; R < document.styleSheets[S][cssRules].length; R++) {
//alert(document.styleSheets[S][cssRules][R].selectorText);
					if (document.styleSheets[S][cssRules][R].selectorText == theClass) {
//alert(document.styleSheets[S][cssRules][R].selectorText);
					 document.styleSheets[S][cssRules][R].style[element] = value;
//alert(document.styleSheets[S][cssRules][R].selectorText);	 
					}
				   }
			   }
		}
	}
}

//获取tagname标签中所有属性attribute的值为zhi的DOM数组//
function getDom(tagname,attribute,zhi){
	tagDOMs=document.getElementsByTagName(tagname);
	if(attribute){
		ge=0;
		needDOMs=new Array();
		if(attribute!="class"){
			if(zhi.search('|')!=-1){	//兼容多个值的情况
				zhis = zhi.split('|');
				for(i=0;i<tagDOMs.length;i++){
					for(k=0;k<zhis.length;k++){
						if(tagDOMs[i].getAttribute(attribute)==zhis[k]){
							needDOMs[ge]=tagDOMs[i];
							ge++;
							break;
						}	
					}
				}		
			} else {
				for(i=0;i<tagDOMs.length;i++){
					if(tagDOMs[i].getAttribute(attribute)==zhi){
						needDOMs[ge]=tagDOMs[i];
						ge++;
					}
				}	
			}
		}else{
			if(zhi.search('|')!=-1){	//兼容多个值的情况
				zhis = zhi.split('|');
				for(i=0;i<tagDOMs.length;i++){
					for(k=0;k<zhis.length;k++){
						if(tagDOMs[i].className==zhis[k]){
							needDOMs[ge]=tagDOMs[i];
							ge++;
							break;
						}	
					}
				}		
			} else {
				for(i=0;i<tagDOMs.length;i++){
					if(tagDOMs[i].className==zhi){
						needDOMs[ge]=tagDOMs[i];
						ge++;
					}
				}	
			}
		}
		return needDOMs;
	}else{
		return tagDOMs;
	}
}


//获取所有style和link标签对象；暂时不用，测试FF时不起作用！！如需使用，请修改后
function getAllSheets() {
	if( !window.ScriptEngine && navigator.__ice_version ) { return document.styleSheets; }
	if( document.getElementsByTagName ) { 
		var Lt = document.getElementsByTagName('link'), St = document.getElementsByTagName('style');
	} else if( document.styleSheets && document.all ) { 
		var Lt = document.all.tags('LINK'), St = document.all.tags('STYLE');
	} else { return []; } 
	for( var x = 0, os = []; Lt[x]; x++ ) {
		var rel = Lt[x].rel ? Lt[x].rel : Lt[x].getAttribute ? Lt[x].getAttribute('rel') : '';
		if( typeof( rel ) == 'string' && rel.toLowerCase().indexOf('style') + 1 ) { os[os.length] = Lt[x]; }
	} 
	for( var x = 0; St[x]; x++ ) { os[os.length] = St[x]; } return os;
}


////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////

