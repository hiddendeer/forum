<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('son_module.php','id参数错误');
}
$link = connect();
$query = "delete from son_module where id={$_GET['id']}";
execute($link, $query);
if (mysqli_affected_rows($link) == 1) {
  skip('son_module.php','恭喜你删除成功');
}
else{
    skip('son_module.php','对不起删除失败，请重试');
}

?>
