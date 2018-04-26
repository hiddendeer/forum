<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
if (isset($_POST['submit'])) {
  foreach ($_POST['sort'] as $key => $val) {
    if (!is_numeric($key) || !is_numeric($val)) {
      skip('son_module.php','排序不合法');
    }
    $query[] = "update son_module set sort = {$val} where id={$key}";
  }
  if(execute($link,$query)){
    skip('son_module.php','排序修改成功');
  }else {
    skip('son_module.php','排序失败');
  }
}
$template['title'] = '小话题列表';
$template['css'] = array('style/public.css');
?>
<?php include 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">
    <div class="title">小话题</div>
    <form method="post">
   <table class="list">
     <tr>
            <th>话题名称</th>
            <th>所属话题</th>
            <th>操作</th>
        </tr>
        <?php
        $query = "select ssm.id,ssm.module_name,ssm.sort,sfm.module_name father_module_name,ssm.member_id from son_module ssm,father_module sfm where ssm.father_module_id=sfm.id order by sfm.id";
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("son_module_delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "你真的要删除小话题{$data['module_name']}";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
            $html = <<<A
        <tr>
            
            <td>{$data['module_name']}[id:{$data['id']}]</td>
            <td>{$data['father_module_name']}</td>
           
            <td><a href="son_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
        </tr>
A;
            echo $html;
        }
        ?>


    </table>
<input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="排序"  />
  </form>
</div>
<?php include 'inc/footer.inc.php' ?>