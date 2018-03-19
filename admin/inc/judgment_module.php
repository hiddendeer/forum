<?php
if (empty($_POST['module_name'])) {
  skip('father_module_add.php','版块名称为空了');
}
if (mb_strlen($_POST['module_name'])>66) {
  skip('father_module_add.php','名称超过66个字符');
}
if (!is_numeric($_POST['sort'])) {
  skip('father_module_add.php','排序必须是数字');
}
// $_POST=escape($link,$_POST);
switch ($check) {
  case 'add':
      $query = "select * from father_module where module_name='{$_POST['module_name']}'";
    break;
  case 'update':
      $query = "select * from father_module where module_name='{$_POST['module_name']}' and id!={$_GET['id']}";
    break;
  default:
    skip('father_module_add.php','验证参数错误');
}
$result = execute($link,$query);
if (mysqli_num_rows($result)) {
  skip('father_module_add.php','已经存在这个版块');
}


 ?>
