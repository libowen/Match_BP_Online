
作者：黎柏文
Email：ruyihe@126.com
当前版本：2.3 参赛版（完成时间 2011年4月20日）
历史版本：2.2 公测版（完成时间 2010年8月）


《比赛编排管理系统》功能与教程简介
一、系统简介
  中文名：比赛编排管理系统      英文名：Match BP Online     联系作者：ruyihe@126.com      测试账号：test 密码：test 
  主要功能：实现比赛的定位积分编排（即瑞士制，又称积分循环制或积分编排制）和非常完善全面的比赛在线编排、管理、发布、查询、共享、协同功能，并配置了多种表格的灵活输出、细致的查看对比及修改、智能自动化编辑等高级功能，结合强大的bbs论坛社区，进而整合成网站式一体化的比赛编排、管理、储存、发布、交流、互动平台。非常适合基层搞比赛（中国象棋、围棋、五子棋、国际象棋、拖拉机、扑克升级等赛事进行积分编排制的比赛）
  未来版本计划：增加office Excel文件（和TXT、其他电子表格等）的数据导出和导入功能（最好是智能识别）；完善牌类拖拉机、扑克升级比赛（目前只是在破同分中增加了总分选项，有点勉强）的编排管理等；增强系统与论坛社区的融合。
二、创新与特色
  1、实现了电脑智能按积分编排规则进行比赛编排配对并输出
  2、实现远程管理，协同管理，网上展示，储存等，编排员可以足不出户远程管理 
  3、方便的管理、打印方式。传统编排程序需要同时携带一台电脑和一台打印机，还需要电源；而本程序只需有打印店在附近，或有智能手机，即可登分、编排并打印结果或手机上网查看编排结果，利于中小型比赛的开展，比赛裁判工作更加公开，传播速度更快速便捷
  4、灵活直观的打印输出，表格显示完全模仿打印预览设计，可以上色标注，修改字体大小、每页行数、比赛地点、时间等信息
  5、网上比赛编排管理在国内/国际上都几近空白；还可增加SNS元素、会员管理功能；


《比赛编排管理系统》源码安装使用说明

一、程序安装
1、解压后，将bp文件夹复制粘贴到网站根目录下，源码程序必须放在网站根目录的bp文件夹下，地址使用 http://yourdomain/bp/
2、修改bp文件夹下的config.inc.php，其中
define("UserName", "*****");		//数据库连接用户名
define("PassWord", "*****");		//数据库连接密码
define("ServerName", "localhost");	//数据库服务器的名称
define("DBName","*****");		//数据库名称
***** 星号部分为你自己的个人配置信息，必须修改

3、安装数据库
直接导入数据库 ruyihe_bp.sql
注：已有账号的登录密码都默认为test，请及时修改


二、使用说明
http://ruyihe.com/bbs/thread-113-1-1.html  《积分编排制方法详解》和文档下载  
http://ruyihe.com/bbs/thread-119-1-1.html  《比赛编排管理系统》新建赛事图文教程  
http://ruyihe.com/bbs/thread-129-1-1.html  《比赛编排管理系统》新建赛事、赛事配置各项参数详解  
http://ruyihe.com/bbs/thread-116-1-1.html  《比赛编排管理系统》使用流程示意图  
http://ruyihe.com/bbs/thread-118-1-1.html  《比赛编排管理系统》用户账号注册及管理图文教程  
http://ruyihe.com/bbs/thread-120-1-1.html  《比赛编排管理系统》查询赛事 图文教程  
http://ruyihe.com/bbs/thread-121-1-1.html  《比赛编排管理系统》收藏赛事 图文教程  
http://ruyihe.com/bbs/thread-122-1-1.html  《比赛编排管理系统》新增选手 图文教程  
http://ruyihe.com/bbs/thread-123-1-1.html  《比赛编排管理系统》选手管理 图文教程  
http://ruyihe.com/bbs/thread-124-1-1.html  《比赛编排管理系统》电脑智能编排对阵 图文教程  
http://ruyihe.com/bbs/thread-125-1-1.html  《比赛编排管理系统》每轮成绩录入 图文教程  
http://ruyihe.com/bbs/thread-126-1-1.html  《比赛编排管理系统》赛事查询恢复 图文教程  
http://ruyihe.com/bbs/thread-127-1-1.html  《比赛编排管理系统》输出、预览、打印各种表格 图文教程  

《比赛编排管理系统》比赛编排操作流程演示 视频 http://www.tudou.com/programs/view/ABQQibqMLpk/
《比赛编排管理系统》简介 视频 http://www.tudou.com/programs/view/FOthLlLB03k/

引用 
<embed src="http://www.tudou.com/v/FOthLlLB03k/&rpid=85797063/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400"></embed>
<embed src="http://www.tudou.com/v/ABQQibqMLpk/&rpid=85797063/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="480" height="400"></embed>
