<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = '子版块修改页-';
$template['css'] = array('style/public.css');
$link = connect();
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  skip('son_module_add.php','参数错误');
}
$query = "select * from son_module where id ='{$_GET['id']}'";
$result = execute($link,$query);
if (!mysqli_num_rows($result)) {
  skip('son_module_add.php','没有这条子版块信息');
}
$data = mysqli_fetch_assoc($result);
if (isset($_POST['submit'])) {
  $check = 'update';
  include 'inc/check_son_module.inc.php';
  $query = "update son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
  // $query = "update son_module set module_name = '{$_POST['module_name']}',sort={$_POST['sort']} where id={$_GET['id']}";
  execute($link,$query);
  if (mysqli_affected_rows($link)==1) {
    skip('son_module.php','修改成功');
  }else{
    skip('son_module.php','修改失败');
  }
}
?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
  <div class="title" style="margin-bottom:20px;">修改子版块-<?php echo $data['module_name']?></div>
  <form method="post">
    <table class="au">
      <tr>
        <td>所在的父版块</td>
        <td>
          <select name="father_module_id">
            <option value="0">===选择父版块===</option>
            <?php
            $query = "select * from father_module";
            $result_father = execute($link,$query);
            while ($data_father=mysqli_fetch_assoc($result_father)) {
              if ($data['father_module_id']==$data_father['id']){
                echo "<option selected='selected' value='{$data_father['id']}'>{$data_father['module_name']}</option>";
              }else{
                echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
              }

            }
            ?>
          </select>
        </td>
        <td>
          必须选择一个所属的父版块
        </td>
      </tr>
      <tr>
        <td>版块名称</td>
        <td><input name="module_name" value="<?php echo $data['module_name']?>" type="text" /></td>
        <td>
          版块名称不得为空，最大不得超过66个字符
        </td>
      </tr>
      <tr>
        <td>版块简介</td>
        <td>
          <textarea name="info"><?php echo $data['info']?></textarea>
        </td>
        <td>
          简介不得多于255个字符
        </td>
      </tr>
      <tr>
        <td>版主</td>
        <td>
          <select name="member_id">
            <option value="0">===选择一个会员为版主</option>
          </select>
        </td>
        <td>
          选一个会员作为版主
        </td>
      </tr>
      <tr>
        <td>排序</td>
        <td><input name="sort" value="<?php echo $data['sort']?>" type="text"/></td>
        <td>
          填写一个数字即可
        </td>
      </tr>
    </table>
    <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="修改"  />
  </form>
</div>
<?php include 'inc/footer.inc.php'  ?>
