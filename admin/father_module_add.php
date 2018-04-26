<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
// include_once 'inc/is_manage_login.inc.php';
if (isset($_POST['submit'])) {
  
  $check = 'add';
  include 'inc/judgment_module.php';
  $query = "insert into father_module(module_name,sort) values ('{$_POST['module_name']}',{$_POST['sort']})";
  execute($link,$query);
  if (mysqli_affected_rows($link) == 1) {
    skip('father_module.php','成功添加');
  } else {
    skip('fater_module_add.php','添加失败');
  }
}
$template['title'] = '大话题添加页';
$template['css'] = array('style/public.css');
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
  <div class="title" style="margin-bottom: 20px">大话题列表</div>
  <form method="post">
    <table class="au">
      <tr>
        <td>话题名称</td>
        <td><input name="module_name" type="text"/></td>
        <td>
          输入话题名称
        </td>
      </tr>
      <tr>
        <td>排序</td>
        <td><input name="sort" value="0" type="text"/></td>
        <td>
          填写一个数字即可
        </td>
      </tr>
    </table>
    <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加"  />
  </form>
</div>

<?php include 'inc/footer.inc.php' ?>
