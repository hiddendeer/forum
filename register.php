<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if ($member_id = is_login($link)) {
	skip('index.php','你已经登录');
}
// var_dump(is_login($link));die();
if(isset($_POST['submit'])){
	include 'inc/check_register.inc.php';
	$query="insert into member(name,pw,register_time) values('{$_POST['name']}','{$_POST['pw']}',now())";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		setcookie('chen[name]',$_POST['name']);
		setcookie('chen[pw]',($_POST['pw']));
		skip('register.php','注册成功！');
	}else{
		skip('register.php','注册失败,请重试！');
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
				<a class="hover" href="index.php">首页</a>
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
		<h2>欢迎注册成为会员</h2>
		<form method="post">
			<label>用户名：<input type="text" name="name"  /><span>*用户名不得为空，并且长度不得超过32个字符</span></label>
			<label>密码：<input type="password" name="pw"  /><span>*密码不得少于6位</span></label>
			<label>确认密码：<input type="password" name="confirm_pw"  /><span>*请输入与上面一致</span></label>
			<label>验证码：<input name="vcode" name="vocode" type="text"  /><span>*请输入下方验证码</span></label>
			<img class="vcode" src="showcode.php" />
			<div style="clear:both;"></div>
			<input class="btn" name="submit" type="submit" value="确定注册" />
		</form>
	</div>
	<div id="footer" class="auto">
		<div class="bottom">
			<a>风之语</a>
		</div>
		<div class="copyright">欢迎加入我们的大家庭</div>
	</div>
</body>
</html>
