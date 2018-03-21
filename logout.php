<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$member_id=is_login($link);
if (!$member_id) {
	skip('index.php','你没有登录不用退出');
}
setcookie('chen[name]','',time()-3600);
setcookie('chen[pw]','',time()-3600);
skip('index.php','退出成功');

 ?>
