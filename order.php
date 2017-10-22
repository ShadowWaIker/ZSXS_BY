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

if ($order['confirmInfo'] == "True") {
    $confirmInfo = true;
} else {
    $confirmInfo = false;
}

if ($order['confirmReceipt'] == "True") {
    $confirmReceipt = true;
} else {
    $confirmReceipt = false;
}

if (strlen($order[EMS]) < 5){
    $ems = "暂无";
} else {
    $ems = $order[EMS];
}

$sql = "SELECT Traces FROM by_ems WHERE LogisticCode = '$order[EMS]' ORDER BY id DESC";
$rs = $db->query($sql);
$res = $rs->fetch(PDO::FETCH_ASSOC);
$json = json_decode($res[Traces]);

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
		<?php if($confirmInfo){print '<div><img height="130" style="margin: -350px auto;opacity: 0.7; transform: rotate(-30deg);" src="c.png"></div>';}?>
		<?php if($confirmReceipt){print '<div><img height="130" style="margin: -750px auto;opacity: 0.7; transform: rotate(-30deg);" src="s.png"></div>';}?>
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
		<div style='text-align:left;background: rgba(45, 45, 45, 0.15); padding: 10px 15px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.15); transition:0.2s; border-image: none; width: 270px; height: 100%; color: rgb(255, 255, 255); line-height: 25px; font-family: "Microsoft YaHei",Helvetica,Arial,sans-serif; font-size: 14px; margin-top: 25px; box-shadow: inset 0px 2px 3px 0px rgba(0,0,0,0.1); text-shadow: 0px 1px 2px rgba(0,0,0,0.1); -moz-border-radius: 6px; -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset; -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset; -o-transition: all .2s; -moz-transition: all .2s; -ms-transition: all .2s;'>
		<?php print "收件地址：".$order[address];?>
		</div>
		<!-- 
		<div>
			<input type="text" name="address" class="username" placeholder="收件地址：<?php //print $order[address];?>" autocomplete="off" disabled="disabled"/>
		</div>
		 -->
		<div>
			<input type="text" name="phone_number" id="phone_number" class="phone_number" placeholder="收件人手机号码：<?php print $order[phone_number];?>" autocomplete="off" id="number" disabled="disabled"/>
		</div>
		<div>
			<input type="text" name="phone_number_bak" id="phone_number_bak" class="phone_number_bak" placeholder="其他联系电话：<?php print $order[phone_number_bak];?>" autocomplete="off" id="number" disabled="disabled"/>
		</div>
		<div>
			<input name="phone_number_bak" disabled="disabled" class="phone_number_bak" id="phone_number_bak" type="text" placeholder="EMS单号：<?php print $ems;?>" autocomplete="off">
		</div>
		<div style='min-height:8rem;text-align:left;background: rgba(45, 45, 45, 0.15); padding: 10px 15px; border-radius: 6px; border: 1px solid rgba(255, 255, 255, 0.15); transition:0.2s; border-image: none; width: 270px; height: 100%; color: rgb(255, 255, 255); line-height: 25px; font-family: "Microsoft YaHei",Helvetica,Arial,sans-serif; font-size: 14px; margin-top: 25px; box-shadow: inset 0px 2px 3px 0px rgba(0,0,0,0.1); text-shadow: 0px 1px 2px rgba(0,0,0,0.1); -moz-border-radius: 6px; -moz-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset; -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1) inset; -o-transition: all .2s; -moz-transition: all .2s; -ms-transition: all .2s;'>邮寄状态 : 
		<?php if(strlen($res[Traces])<5){
		    print '包裹等待揽收。';
		} else {
		    $json = json_decode($res[Traces]);
		    foreach ($json as $data){
		        print '<br>['.$data->AcceptTime.'] - &gt; '.$data->AcceptStation;
		    }
}?>
		</div>
	</form>
	<?php if(!$confirmInfo){print '<div><button id="confirmInfo">确认邮寄信息填写无误</button></div>';}?>
	<?php if(!$confirmReceipt){print '<div><button id="confirm">确认已经收到证件</button></div>';}?>
	<!-- <div><button id="confirm" style="background: rgba(158, 158, 158, 1);">确认已经收到证件</button></div> -->
	<div><button class="register-tis" id="logout" type="button">&gt; 退出登录 &lt;</button></div>
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
   $("#confirmInfo").click (function () {
	//alert("当前不在确认时间段！");
	$.post("./confirmInfo.php",{},function(data){$("#end").html(data);});
    })
   $("#confirm").click (function () {
	//alert("当前不在确认时间段！");
    $.post("./confirmReceipt.php",{},function(data){$("#end").html(data);});
    })
  })
 </script>
</html>