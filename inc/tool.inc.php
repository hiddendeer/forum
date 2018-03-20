<?php
function skip($url,$message) {
  $html = <<<A
  <!DOCTYPE html>
  <html lang="zh-CN">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="refresh" content="3;URL = {$url}" />
  <title>正在跳转</title>
  <link rel="stylesheet" type="text/css" href="style/remind.css" />
  </head>
  <body>
  <div class="notice"><span class="pic ask"></span>{$message}<a href="{$url}">3秒后自动跳转</a></div>
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

 ?>
