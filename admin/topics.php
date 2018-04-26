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
<style>
  .cancel-top {
    color: #ff0000e3;
  }
</style>
<div id="main" style="height:1000px;">
    <div class="title">所有话题</div>
   <table class="list">
     <tr>
      <th>#id</th>
          <th>话题标题</th>
          <th>所属话题</th>
          <th>发布人</th>
          <th>发布时间</th>
          <th>操作</th>
      </tr>
      <?php
        $where_clause = "";
        if(isset($_GET['mid']))
        {
          $where_clause = "where content.module_id=".$_GET['mid'];
        }
        $query = "select content.*, son_module.module_name, member.name 
                  from content 
                  join son_module on content.module_id=son_module.id 
                  join member on content.member_id=member.id 
                  " . $where_clause . " order by content.top desc,content.time desc ";
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
          // 置顶
          $isTop = $data['top']!=0? "<span class='cancel-top'>取消置顶</span>" : "置顶";

          $tmp_url = urlencode($_SERVER['REQUEST_URI']);
          $action = $data['top']!=0? "0" : "1";
          $put_top_url = "topic_put_top.php?id={$data['id']}&return_url={$tmp_url}&action={$action}";


          $url = urlencode("topic_delete.php?id={$data['id']}");
          $return_url = urlencode($_SERVER['REQUEST_URI']);
          $message = "你真的要删除话题{$data['title']}?";
          $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
          $html = <<<A
        <tr>
        <td>{$data['id']}</td>
            <td>{$data['title']}</td>
            <td><a href="{$_SERVER['REQUEST_URI']}?mid={$data['module_id']}">{$data['module_name']}</a></td>
            <td>{$data['name']}</td>
            <td>{$data['time']}</td>
        
            <td><a href="$put_top_url">[{$isTop}]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
        </tr>
A;
          echo $html;
      }
      ?>


    </table>
</div>
<?php include 'inc/footer.inc.php' ?>