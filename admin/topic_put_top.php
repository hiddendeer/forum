<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('topics.php','id参数错误');
}
$link = connect();
// include_once 'inc/is_manage_login.inc.php';

$action = '0';
if(isset($_GET['action']) && $_GET['action']==='1')
{
    $action = '1';
}
if($action === '1')
{
    $query = "update content set content.time=now(),content.top=1 where content.id={$_GET['id']}";
} else {
    $query = "update content set content.time=now(),content.top=0 where content.id={$_GET['id']}";
}

execute($link, $query);
if (mysqli_affected_rows($link) == 1) {
  skip('topics.php','恭喜你置顶成功');
}
else{
    skip('topics.php','对不起置顶失败，请重试');
}

?>
