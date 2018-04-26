<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('father_module.php','id参数错误');
}
$link = connect();
// include_once 'inc/is_manage_login.inc.php';
$query = "select * from son_module where father_module_id={$_GET['id']}";
$result = execute($link,$query);
if (mysqli_num_rows($result)) {
  skip('father_module.php','大版块下面存在子版块');
  exit;
}
$query = "delete from father_module where id={$_GET['id']}";
execute($link, $query);
if (mysqli_affected_rows($link) == 1) {
  skip('father_module.php','恭喜你删除成功');
}
else{
    skip('father_module.php','对不起删除失败，请重试');
}

?>
