<?php

/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170614
 *
 */
session_start();
require_once 'public.php';/*
var_dump($_POST);
echo "<br>".implode(',',$_POST['checkbox']);
die();*/
if(empty($_SESSION["user"])){
	die("<script language=javascript>alert('登录超时 ！');window.location='index.html'</script>");
} else {
	$user = $_SESSION["user"];
}

$pdo = new DataBase;
$db = $pdo->mysqlconn();

$sql = "SELECT by_order FROM edu_graduate WHERE xh = '$user'";
$rs = $db->query($sql);
$info = $rs->fetch(PDO::FETCH_ASSOC);

if(!empty($info[by_order])){
    die("<script language=javascript>alert('您已经填写过邮寄信息！');window.location='order.php'</script>");
}

$name = $_POST['name'];
if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$name) || ($name == "")){
	die("<script language=javascript>alert('收件人姓名不正确！');window.location='mail.html'</script>");
}
$address = $_POST['address'];
if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$address) || ($address == "")){
	die("<script language=javascript>alert('收件地址不正确！');window.location='mail.html'</script>");
}
$phone_number = $_POST['phone_number'];
if(!is_numeric($phone_number) || strlen($phone_number) != 11){
    die("<script language=javascript>alert('收件人手机号码不正确！');window.location='mail.html'</script>");
}
$code = $_POST['code'];
if(!is_numeric($code) || strlen($code) != 4){
    die("<script language=javascript>alert('验证码不正确！');window.location='mail.html'</script>");
}
$phone_number_bak = $_POST['phone_number_bak'];
if(!is_numeric($phone_number_bak) || strlen($phone_number_bak) != 11){
    die("<script language=javascript>alert('其他联系电话不正确！');window.location='mail.html'</script>");
}
$order = implode(',',$_POST['checkbox']);
if(preg_match("/[\'.:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$order)){
	die("<script language=javascript>alert('邮寄项目不正确！');window.location='mail.html'</script>");
}
/*
if(!empty($_POST['byz'])){
	$byz = $_POST['byz'];
} else {
	$byz = 'F';
}
if(!empty($_POST['xwz'])){
	$xwz = $_POST['xwz'];
} else {
	$xwz = 'F';
}
if(!empty($_POST['bdz'])){
	$bdz = $_POST['bdz'];
} else {
	$bdz = 'F';
}
if(!empty($_POST['jszgz'])){
	$jszgz = $_POST['jszgz'];
} else {
	$jszgz = 'F';
}
*/

$sql = "SELECT * FROM verification_code WHERE phone = '$phone_number' ORDER BY id DESC";
$rs = $db->query($sql);
$res = $rs->fetch(PDO::FETCH_ASSOC);
$dbcode = $res[code];
if($dbcode != $code){
	die("<script language=javascript>alert('验证码错误，请重新获取验证码！');window.location='mail.html'</script>");
}
$start = $res[time];
$end = date("Y/m/d H:i:s");
$term = $res[term];
$countmin=floor((strtotime($end)-strtotime($start))/60);
if($countmin > $term){
	die("<script language=javascript>alert('验证码超时，请重新获取验证码！');window.location='mail.html'</script>");
} else {
	$sql = "INSERT INTO by_order(name, address, phone_number, phone_number_bak, orders, time) VALUES ('$name','$address','$phone_number','$phone_number_bak','$order','".date("Y/m/d H:i:s")."')";
	$res = $db->exec($sql);
	if($res){
		$sql = "SELECT * FROM by_order WHERE phone_number = '$phone_number' ORDER BY id DESC";
		$rs = $db->query($sql);
		$info = $rs->fetch(PDO::FETCH_ASSOC);
		$sql = "UPDATE edu_graduate SET by_order = '$info[id]' WHERE xh = '$user'";
		$rs = $db->query($sql);
		if($rs) {
			die("<script language=javascript>alert('提交成功！');window.location='order.php'</script>");
		} else {
			die("<script language=javascript>alert('提交失败，请重试！');window.location='mail.html'</script>");
		}
	}
}






?>