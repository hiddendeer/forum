<?php
if (!is_numeric($_POST['father_module_id'])) {
  skip('son_module_add.php','不得为空');
}
$query = "select * from father_module where id={$_POST['father_module_id']}";
$result = execute($link,$query);
if (mysqli_num_rows($result)==0) {
  skip('son_module_add.php','版块不存在');
}
if (empty($_POST['module_name'])) {
  skip('son_module_add.php','版块名称为空了');
}
if (mb_strlen($_POST['module_name'])>66) {
  skip('son_module_add.php','名称超过66个字符');
}
switch ($check) {
  case 'add':
      $query = "select * from son_module where module_name='{$_POST['module_name']}'";
    break;
  case 'update':
      $query = "select * from son_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
    break;
  default:
    skip('son_module.php','验证参数错误');
}
$result = execute($link,$query);
if (mysqli_num_rows($result)) {
  skip('son_module_add.php','子版块已经存在');
}
if (mb_strlen($_POST['info'])>255) {
  skip('son_module_add.php','名简介多于255个字符');
}
if (!is_numeric($_POST['sort'])) {
  skip('father_module_add.php','排序只能是数字');
}
 ?>
