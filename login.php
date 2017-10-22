<?php

/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170614
 *
 */
session_start();
require_once 'public.php';
$username = $_POST['username'];
if(!is_numeric($username) || strlen($username) != 12){
    die("<script language=javascript>alert('学号不正确！');window.location='index.html'</script>");
}
$password = $_POST['idcard'];
if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$password)){
    die("<script language=javascript>alert('身份证号码不正确！');window.location='index.html'</script>");
}

$pdo = new DataBase;
$db = $pdo->mysqlconn();

$sql = "SELECT * FROM edu_graduate WHERE xh = '$username' AND sfzh='$password'";
$rs = $db->query($sql);
$info = $rs->fetch(PDO::FETCH_ASSOC);

if($info){
	$_SESSION["user"] = trim($info[XH]);
	if(!empty($info[by_order])){
		die("<script language=javascript>alert('您已经填写过邮寄信息！');window.location='order.php'</script>");
	}else {
	    $sql = "SELECT * FROM site_config";
	    $rs = $db->query($sql);
	    $config = $rs->fetch(PDO::FETCH_ASSOC);
	    if (strtotime(date("Y/m/d H:i:s")) > strtotime($config[endTime])){
	        die("<script language=javascript>alert('系统已经关闭！');window.location='index.html'</script>");
	    } else {
	        die("<script language=javascript>alert('登陆成功！');window.location='mail.html'</script>");
	    }
	}
} else {
    die("<script language=javascript>alert('学号或身份证号码不正确！');window.location='index.html'</script>");
}

?>