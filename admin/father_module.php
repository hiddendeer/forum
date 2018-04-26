<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
include_once '../inc/tool.inc.php';
$link = connect();
if (isset($_POST['submit'])) {
  foreach ($_POST['sort'] as $key => $val) {
    if (!is_numeric($key) || !is_numeric($val)) {
      skip('father_module.php','排序不合法');
    }
    $query[] = "update father_module set sort = {$val} where id={$key}";
  }
  if(execute($link,$query)){
    skip('father_module.php','排序修改成功');
  }else {
    skip('father_module.php','排序失败');
  }
}
$template['title'] = '大话题列表';
$template['css'] = array('style/public.css');
?>
<?php include 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">
    <div class="title">大话题列表</div>
    <form method="post">
   <table class="list">
     <tr>
            
            <th>话题名称</th>
            <th>操作</th>
        </tr>
        <?php
        $query = "select * from father_module";
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("father_module_delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "你真的要删除大话题{$data['module_name']}";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
            $html = <<<A
        <tr>
            
            <td>{$data['module_name']}[id:{$data['id']}]</td>
            <td><a href="father_module_update.php?id={$data['id']}">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
        </tr>
A;
            echo $html;

        }

        ?>


    </table>

    </form>
</div>
<?php include 'inc/footer.inc.php' ?>
