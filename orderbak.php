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

$sql = "SELECT xm,xh,by_order FROM edu_graduate WHERE xh = '$user'";
$rs = $db->query($sql);
$info = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM by_order WHERE id = '$info[by_order]'";
$rs = $db->query($sql);
$order = $rs->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>邮寄信息丨离校手续办理丨忻州师范学院</title>
<link rel="stylesheet" href="css/style.css">
<body>
<div class="register-container">
	<h1>忻州师范学院</h1>
	
	<div class="connect">
		<p>2017届毕业生离校手续办理&nbsp;|&nbsp;邮寄信息</p>
	</div>
	
	<form action="" method="post" id="mailMsgForm">
		<div>
			<input type="text" name="name" class="username" placeholder="姓名：<?php print $info[xm];?>" autocomplete="off" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="name" class="username" placeholder="学号：<?php print $info[xh];?>" autocomplete="off" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="name" class="username" placeholder="邮寄内容：<?php print $order[orders];?>" autocomplete="off" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="name" class="username" placeholder="收件人姓名：<?php print $order[name];?>" autocomplete="off" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="address" class="username" placeholder="收件地址：<?php print $order[address];?>" autocomplete="off" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="phone_number" id="phone_number" class="phone_number" placeholder="收件人手机号码：<?php print $order[phone_number];?>" autocomplete="off" id="number" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="phone_number_bak" id="phone_number_bak" class="phone_number_bak" placeholder="其他联系电话：<?php print $order[phone_number_bak];?>" autocomplete="off" id="number" disabled="disabled"/>
		</div>
		<!--
		<button id="submit" type="submit" disabled="disabled">提&nbsp;交</button>
		-->
	</form>
	<div style="margin-top:10px;">
		<button type="button" id="logout" class="register-tis">> 退出登录</button>
	</div>
	<div id="end" style="height:30px"></div>
</div>

</body>
<script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
<script src="js/common.js"></script>
<!--背景图片自动更换-->
<!--
<script src="js/supersized.3.2.7.min.js"></script>
<script src="js/supersized-init.js"></script>
-->
<!--表单验证-->
<script src="js/jquery.validate.min.js?var1.14.0"></script>
<script>
  $(function(){
   $("#logout").click (function () {
    $.post("./logout.php",{},function(data){$("#end").html(data);});
    })
  })
 </script>
</html>