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
if(empty($_SESSION["user"])){
	die("<script language=javascript>alert('登录超时！');window.location='index.html'</script>");
} else {
	$user = $_SESSION["user"];
}
$pdo = new DataBase;
$db = $pdo->mysqlconn();

$sql = "SELECT xm,xh,byny,by_order FROM edu_graduate WHERE xh = '$user'";
$rs = $db->query($sql);
$info = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "UPDATE by_order SET confirmReceipt = 'True' WHERE id = '$info[by_order]'";
$status = $db->exec($sql);
if ($status) {
    $sql = "INSERT INTO log(byny, xh, lb, sj, czr, ip, client, bz) VALUES ('$info[byny]', '$info[xh]', '确认收到证件', '".date("Y/m/d H:i:s")."', '$info[xm]', null, 'by_web', null)";
    $status1 = $db->exec($sql);
    if ($status1) {
        die("<script language=javascript>alert('确认成功！');window.location='order.php';</script>");
    } else {
        die("<script language=javascript>alert('确认失败！');window.location='order.php';</script>");
    }
} else {
    die("<script language=javascript>alert('确认失败！');window.location='order.php';</script>");
}

?>