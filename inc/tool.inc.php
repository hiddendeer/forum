<?php
function skip($url,$message) {
  $html = <<<A
  <!DOCTYPE html>
  <html lang="zh-CN">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="refresh" content="1;URL = {$url}" />
  <title>正在跳转</title>
  <link rel="stylesheet" type="text/css" href="style/remind.css" />
  </head>
  <body>
  <div class="notice"><span class="pic ask"></span>{$message}<a href="{$url}">即将跳转，请稍等...</a></div>
  <div style="text-align:center;"><img src='style/load.jpg'></div>
  </body>
  </html>
A;
echo $html;
exit();
}
function is_login($link){
	if(isset($_COOKIE['chen']['name']) && isset($_COOKIE['chen']['pw'])){
		$query="select * from member where name='{$_COOKIE['chen']['name']}' and pw='{$_COOKIE['chen']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			$data=mysqli_fetch_assoc($result);
			return $data['id'];
		}else{
			return false;
		}
	}else{
		return false;
	}
}
function check_user($member_id,$content_member_id){
	if($member_id==$content_member_id){
		return true;
	}else{
		return false;
	}
}
//验证后台管理员是否登录
function is_manage_login($link){
	if(isset($_SESSION['manage']['name']) && isset($_SESSION['manage']['pw'])){
		$query="select * from manage where name='{$_SESSION['manage']['name']}' and sha1(pw)='{$_SESSION['manage']['pw']}'";
		$result=execute($link,$query);
		if(mysqli_num_rows($result)==1){
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}

 ?>
