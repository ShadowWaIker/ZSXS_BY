<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170614
 *
 */

//1开启session
session_start();

//2、清空session信息
$_SESSION = array();
  
//3、清楚客户端sessionid
if(isset($_COOKIE[session_name()]))
{
  setCookie(session_name(),'',time()-3600,'/');
}
//4、彻底销毁session
session_destroy();

die("<script language=javascript>alert('退出登录成功！');window.location='index.html'</script>");
?>