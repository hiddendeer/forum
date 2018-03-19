<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$template['title'] = '子版块添加页';
$template['css'] = array('style/public.css');
$link = connect();
if (isset($_POST['submit'])) {
  $check = 'add';
  include 'inc/check_son_module.inc.php';
  $query = "insert into son_module(father_module_id,module_name,info,member_id,sort) values ({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
  execute($link,$query);
  if (mysqli_affected_rows($link) == 1) {
    skip('son_module.php','成功添加');
  } else {
    skip('son_module_add.php','添加失败');
  }
}
 ?>
<?php include 'inc/header.inc.php' ?>
<div id="main">
    <div class="title" style="margin-bottom:20px;">添加子版块</div>
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
                  echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
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
          <td><input name="module_name" type="text" /></td>
          <td>
            版块名称不得为空，最大不得超过66个字符
          </td>
        </tr>
        <tr>
          <td>版块简介</td>
          <td>
          <textarea name="info"></textarea>
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
          <td><input name="sort" value="0" type="text"/></td>
          <td>
            填写一个数字即可
          </td>
        </tr>
      </table>
      <input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加"  />
    </form>
</div>
<?php include 'inc/footer.inc.php'  ?>
