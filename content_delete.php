<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','请没有登录!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','帖子id参数不合法!');
}
$query="select member_id from content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
    if(check_user($member_id,$data_content['member_id'])){
		$query="delete from content where id={$_GET['id']}";
		execute($link, $query);
		if(mysqli_affected_rows($link)==1){
			skip("member.php?id={$member_id}",'恭喜你，删除成功!');
		}else{
			skip("member.php?id={$member_id}",'对不起删除失败!');
		}
	}else{
		skip('index.php','这个帖子不属于你，你没有权限!');
	}
}else{
	skip('index.php','帖子不存在!');
}
?>