<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$template['title'] = '更新版块';
$template['css'] = array('style/public.css');
$link = connect();
$query = "select * from father_module where id ='{$_GET['id']}'";
$result = execute($link,$query);
$data = mysqli_fetch_assoc($result);
 ?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
  <div class="title" style="margin-bottom: 20px">修改-详情页</div>
  <form method="post">
    <table class="au">
      <tr>
        <td>版块名称</td>
        <td><input name="module_name" value="<?php echo $data['module_name'] ?>" type="text"/></td>
        <td>
          输入版块名
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
    <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加"  />
  </form>
</div>
<?php include 'inc/footer.inc.php' ?>
