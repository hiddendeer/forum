<?php
/*
*首页
*/
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
$member_id = is_login($link);

$template['title'] = '首页';
$template['css'] = array('style/public.css','style/index.css');
?>
<?php include 'inc/header.inc.php' ?>

<style media="screen">
  body {
    height: 100%;
    background-image: url(style/indexbg.jpg);
    background-repeat: no-repeat;
    /* filter:blur(10px);
    -webkit-filter:blur(10px);
    -moz-filter:blur(10px);
    -ms-filter:blur(10px);
    -o-filter:blur(10px); */
  }
</style>

<div id="hot" class="auto">
  <div class="title">热门动态</div>
  <ul class="newlist">
    <!-- 20条 -->
    <li><a href="#">[库队]</a> <a href="#">实战项目录制中...</a></li>

  </ul>
  <div style="clear:both;"></div>
</div>
<?php
$query = "select * from father_module order by sort desc";
$result_father = execute($link,$query);
while ($data_father=mysqli_fetch_assoc($result_father)) {
?>
<div class="box auto">
  <div class="title">
    <a href="list_father.php?id=<?php echo $data_father['id'] ?>" style="color:#105cb6;"><?php echo $data_father['module_name'] ?></a>
  </div>
  <div class="classList">
    <?php
    $query = "select * from son_module where father_module_id={$data_father['id']}";
    $result_son = execute($link,$query);
    if (mysqli_num_rows($result_son)) {
        while ($data_son=mysqli_fetch_assoc($result_son)) {
          $query = "select count(*) from content where module_id={$data_son['id']} and time > CURDATE() ";
           $count_today = num($link,$query);
           $query = "select count(*) from content where module_id={$data_son['id']}";
            $count_all = num($link,$query);
      $html =<<<A
      <div class="childBox new">
        <h2><a href="#">{$data_son['module_name']}</a> <span>(今日{$count_today})</span></h2>
        帖子：{$count_all}<br />
      </div>
A;
echo $html;
        }
      /*
      <div class="childBox new">
        <h2><a href="#">私队</a> <span>(今日39)</span></h2>
        帖子：1939539<br />
      </div>
      */
    }else{
        echo '<div style="padding:10px 0;">暂无子版块...</div>';
    }
     ?>
  <div style="clear:both;"></div>
  </div>
</div>
<?php } ?>
  </div>
</div>
<?php include 'inc/footer.inc.php' ?>
