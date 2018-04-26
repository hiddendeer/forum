<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = '更新话题';
$template['css'] = array('style/public.css');
$link = connect();
// include_once 'inc/is_manage_login.inc.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  skip('fater_module_add.php','参数错误');
}
$query = "select * from father_module where id ='{$_GET['id']}'";
$result = execute($link,$query);
if (!mysqli_num_rows($result)) {
  skip('fater_module_add.php','没有这条信息');
}
if (isset($_POST['submit'])) {
  $check = 'update';
  include 'inc/judgment_module.php';
  $query = "update father_module set module_name = '{$_POST['module_name']}',sort={$_POST['sort']} where id={$_GET['id']}";
  execute($link,$query);
  if (mysqli_affected_rows($link)==1) {
    skip('father_module.php','修改成功');
  }else{
    skip('father_module.php','修改失败');
  }
}
$data = mysqli_fetch_assoc($result);
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
  <div class="title" style="margin-bottom: 20px">修改-<?php echo $data['module_name']?></div>
  <form method="post">
    <table class="au">
      <tr>
        <td>版块名称</td>
        <td><input name="module_name" value="<?php echo $data['module_name'] ?>" type="text"/></td>
        <td>
          输入话题名
        </td>
      </tr>
      <tr>
        <td>排序</td>
        <td><input name="sort" value="<?php echo $data['sort']?>" type="text"/></td>
        <td>
          填写一个数字
        </td>
      </tr>
    </table>
    <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改"  />
  </form>
</div>
<?php include 'inc/footer.inc.php' ?>
