<?php
/*
*回复帖子
*/
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
if (!$member_id = is_login($link)) {
skip('login.php','请登录之后再回复');
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php', '回复的帖子参数不合法!');
  }

$query = "select sc.id,sc.title,sm.name from content sc,member sm where sc.id={$_GET['id']} and sc.member_id=sm.id";
$result_content = execute($link,$query);
  if(mysqli_num_rows($result_content)!=1){
    skip('index.php', '回复的帖子不存在!');
  }
  if(isset($_POST['submit'])){
    include 'inc/check_reply.inc.php';
    $query = "insert into reply(content_id,content,time,member_id) values({$_GET['id']},'{$_POST['content']}',now(),{$member_id})";
    execute($link,$query);
    if(mysqli_affected_rows($link)==1){
        skip("show.php?id={$_GET['id']}", '回复成功!');
    }else{
        skip($_SERVER['REQUEST_URL'], '回复失败!');
    }
}
$data_content = mysqli_fetch_assoc($result_content);
$template['title']='回复页';
$template['css'] = array('style/public.css','style/publish.css');
?>
<?php include 'inc/header.inc.php' ?>
<div id="position" class="auto">
    <a>首页</a> &gt; <a>NBA</a> &gt;回复帖子
</div>
<div id="publish">
<div>回复：由 <?php echo $data_content['name']?> 发布的: <?php echo $data_content['title']?></div>
<form method="post">
    <textarea name="content" class="content"></textarea>
    <input class="" style="    width: 80px;
    height: 32px;
    background-color: #2a5caa;
    color: white;
    font-size: 16px;
    font-weight: bold;" type="submit" name="submit" value="回复" />
    <div style="clear:both;"></div>
</form>
</div>

<?php include 'inc/footer.inc.php' ?>