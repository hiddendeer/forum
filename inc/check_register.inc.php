<?php
if (empty($_POST['name'])) {
  skip('register.php','用户名不得为空');
}
if (mb_strlen($_POST['name'])>32) {
  skip('register.php','用户名长度最好不要超过32字符');
}
if (mb_strlen($_POST['pw'])<6) {
  skip('register.php','密码不得少于6位');
}
if ($_POST['pw']!=$_POST['confirm_pw']) {
  skip('register.php','两次密码输入的不一样');
}
if (strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
  skip('register.php','验证码输入错误');
}
$query = "select * from member where name='{$_POST['name']}'";
$result = execute($link,$query);
if (mysqli_num_rows($result)) {
  skip('register.php','用户已经存在');
  exit;
}
 ?>
