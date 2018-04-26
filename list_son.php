<?php
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
include_once 'inc/page.inc.php';
$link = connect();
$member_id=is_login($link);
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
  skip('index.php', '副版块id参数不合法!');
}
$query="select * from son_module where id={$_GET['id']}";
$result_son=execute($link,$query);
if(mysqli_num_rows($result_son)!=1){
	skip('index.php','副版块不存在!');
}

$query="update content set times=times+1 where id={$_GET['id']}";
execute($link,$query);

$data_son=mysqli_fetch_assoc($result_son);
$query = "select * from father_module where id={$data_son['father_module_id']}";
$result_father=execute($link,$query);
$data_father=mysqli_fetch_assoc($result_father);

$query="select count(*) from content where module_id={$_GET['id']}";
$count_all=num($link,$query);
$query="select count(*) from content where  module_id={$_GET['id']} and time>CURDATE()";
$count_today=num($link,$query);

$query="select * from member where id={$data_son['member_id']}";
$result_member=execute($link, $query);

$template['title'] = '副版块列表';
$template['css'] = array('style/public.css','style/list.css');
?>
<?php include 'inc/header.inc.php' ?>
<style>
  .top {
    color: #ff0000e3;
  }
</style>
<div id="position" class="auto">
<?php

 ?>
  <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a> &gt; <a><?php echo $data_son['module_name'] ?></a>
</div>
<div id="main" class="auto">
  <div id="left">
    <div class="box_wrap">
      <h3><?php echo $data_son['module_name'] ?></h3>
      <div class="num">
        今日：<span><?php echo $count_today?></span>&nbsp;&nbsp;&nbsp;
        总帖：<span><?php echo $count_all?></span>
      </div>
      <div class="moderator">
    </div>
      <div class="notice"><?php echo $data_son['info'] ?></div>
      <div class="pages_wrap">
        <!-- <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id'] ?>" target="_blank"></a> -->
        <div class="pages">
          <?php
              $page = page($count_all,4);
              echo $page['html'];
           ?>
        </div>
        <div style="clear:both;"></div>
      </div>
    </div>
    <div style="clear:both;"></div>
    <ul class="postsList">
    <div id="hot" class="auto">
  <div class="title" style="color:red;"></div>
  <ul class="newlist">
    <!-- 20条 -->
    <!-- <li><a href="#">[库队]</a> <a href="#">实战项目录制中...</a></li> -->
    

  </ul>
  <div style="clear:both;"></div>
</div>
      <?php
      $query="select
      content.title,content.id,content.time,content.times,content.member_id,content.top,member.name,member.photo,son_module.module_name,son_module.id ssm_id
      from content,member,son_module where
      content.module_id={$_GET['id']} and
      content.member_id=member.id and
      content.module_id=son_module.id order by content.top desc,content.time desc {$page['limit']};";
      $result_content=execute($link,$query);
      	while($data_content=mysqli_fetch_assoc($result_content)){
       ?>
       <li>
         <div class="smallPic">
           <a href="#">
             <img width="45" height="45"src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photos.jpg';} ?>">
           </a>
         </div>
         <div class="subject">
           <div class="titleWrap">
              <h2>
                <?php if($data_content['top']!=0) echo "[<span class='top'>置顶</span>]";?>
                <a target="_blank" href="show.php?id=<?php echo $data_content['id']?>">
                  <?php echo $data_content['title'] ?></a>
              </h2>
            </div>
           <p>
             楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;
           </p>
         </div>
         <div class="count">
           <p>
             回复<br /><span><?php $query="select count(*) from reply where content_id={$data_content['id']}"; echo num($link,$query)?></span></span>
           </p>
           <p>
             浏览<br /><span><?php echo $data_content['times']?></span>
           </p>
         </div>
         <div style="clear:both;"></div>
       </li>
    <?php } ?>
    </ul>
    <div class="pages_wrap">
      <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id']?>" target="_blank"></a>
      <div class="pages">
      <?php echo $page['html']; ?>
      </div>
      <div style="clear:both;"></div>
    </div>
  </div>
  <div id="right">
    <div class="classList">
      <div class="title">版块列表</div>
      <ul class="listWrap">
        <?php
      $query="select * from father_module";
      $result_father=execute($link, $query);
      while($data_father=mysqli_fetch_assoc($result_father)){
      ?>
        <li>
          <h2><a href="list_father.php?id=<?php echo $data_father['id'] ?>"><?php echo $data_father['module_name'] ?></a></h2>
          <ul>
            <?php
              $query = "select * from son_module where father_module_id={$data_father['id']}";
              $result_son = execute($link,$query);
              while($data_son=mysqli_fetch_assoc($result_son)){
              ?>
            <li><h3><a href="list_son.php?id=<?php echo $data_son['id'] ?>"><?php echo $data_son['module_name'] ?></a></h3></li>
            <?php
              }
             ?>
          </ul>
        </li>
        <?php
         }
         ?>
      </ul>
    </div>
  </div>
  <div style="clear:both;"></div>
</div>
<?php include 'inc/footer.inc.php' ?>
