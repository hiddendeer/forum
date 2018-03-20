<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
if ($member_id = is_login($link)) {
	skip('index.php','你登录过了');
}
if (isset($_POST['submit'])) {
	include 'inc/check_login.inc.php';
	$query = "select * from member where name='{$_POST['name']}' and pw='{$_POST['pw']}'";
	$result = execute($link,$query);
	// var_dump(mysqli_num_rows($result)==1);exit;
	if (mysqli_num_rows($result)==1) {
					setcookie('chen[name]',$_POST['name'],time()+$_POST['time']);
					setcookie('chen[pw]',$_POST['pw'],time()+$_POST['time']);
					skip('index.php','登录成功');
	}else{
		skip('login.php','用户名或密码错误');
	}
}
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="stylesheet" type="text/css" href="style/public.css" />
<link rel="stylesheet" type="text/css" href="style/register.css" />
</head>
<body>
	<div class="header_wrap">
		<div id="header" class="auto">
			<div class="logo">风之帖</div>
			<div class="nav">
				<a class="hover">首页</a>
				<a>新帖</a>
				<a>话题</a>
			</div>
			<div class="serarch">
				<form>
					<input class="keyword" type="text" name="keyword" placeholder="搜索其实很简单" />
					<input class="submit" type="submit" name="submit" value="" />
				</form>
			</div>
			<div class="login">
				<a href="login.php">登录</a>&nbsp;
				<a href="register.php">注册</a>
			</div>
		</div>
	</div>
	<div style="margin-top:55px;"></div>
	<div id="register" class="auto">
		<h2>请登录</h2>
		<form method="post">
			<label>用户名：<input type="text" name="name"  /><span></span></label>
			<label>密码：<input type="password" name="pw"  /><span></span></label>
			<!-- <label>确认密码：<input type="password"  /><span></span></label> -->
			<label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
			<img class="vcode" src="showcode.php" />
			<label>自动登录：
				<select style="width:236px;height:25px;" name="time">
					<option value="3600">1小时内</option>
					<option value="86400">1天内</option>
					<option value="259200">3天内</option>
					<option value="2592000">30天内</option>
				</select>
				<span>*公共电脑上请勿长期自动登录</span>
			</label>
			<div style="clear:both;"></div>
			<input class="btn" type="submit" name="submit" value="登录" />
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>风之帖</a>
		</div>
		<div class="copyright">这是一个自由发帖的大家庭</div>
	</div>
</body>
</html>
