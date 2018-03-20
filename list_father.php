<?php
/*
*主版块列表,子版块的内容
*/
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link = connect();
if (!$member_id = is_login($link)) {
  skip('login.php','请登录发帖');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php', '主版块id参数不合法!');
}
$query="select * from father_module where id={$_GET['id']}";
$result_father=execute($link, $query);
$data_father=mysqli_fetch_assoc($result_father);
if(mysqli_num_rows($result_father)==0){
	skip('index.php','父版块不存在!');
}
$query="select * from son_module where father_module_id={$_GET['id']}";
$result_son=execute($link,$query);
$id_son='';
$son_list='';
while($data_son=mysqli_fetch_assoc($result_son)){
  $id_son.=$data_son['id'].',';
  $son_list.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
  }
  $id_son=trim($id_son,',');
  if($id_son==''){
	$id_son='-1';
}
  $query="select count(*) from content where module_id in({$id_son})";
$count_all=num($link,$query);
$query="select count(*) from content where module_id in({$id_son}) and time>CURDATE()";
$count_today=num($link,$query);
$template['title'] = '主版块列表';
$template['css'] = array('style/public.css','style/list.css');
 ?>
<?php include 'inc/header.inc.php' ?>
<div id="position" class="auto">
  <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a>
</div>
<div id="main" class="auto">
  <div id="left">
    <div class="box_wrap">
      <h3><?php echo $data_father['module_name']?></h3>
      <div class="num">
        今日：<span><?php echo $count_today?></span>&nbsp;&nbsp;&nbsp;
        总帖：<span><?php echo $count_all?></span>
        <div class="moderator"> 子版块： <?php echo $son_list ?></div>
      </div>
      <div class="pages_wrap">
        <a class="btn publish" href=""></a>
        <div class="pages">
          <a>« 上一页</a>
          <a>1</a>
          <span>2</span>
          <a>3</a>
          <a>4</a>
          <a>...13</a>
          <a>下一页 »</a>
        </div>
        <div style="clear:both;"></div>
      </div>
    </div>
    <div style="clear:both;"></div>
    <ul class="postsList">
<?php
$query="select
content.title,content.id,content.time,content.times,content.member_id,member.name,member.photo,son_module.module_name,son_module.id ssm_id
from content,member,son_module where
content.module_id in({$id_son}) and
content.member_id=member.id and
content.module_id=son_module.id";
$result_content=execute($link,$query);
	while($data_content=mysqli_fetch_assoc($result_content)){
 ?>
      <li>
        <div class="smallPic">
          <a href="#">
            <img width="45" height="45"src="<?php if($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';} ?>">
          </a>
        </div>
        <div class="subject">
          <div class="titleWrap"><a href="#">[<?php echo $data_content['module_name'] ?>]</a>&nbsp;&nbsp;<h2><a href="#"><?php echo $data_content['title'] ?></a></h2></div>
          <p>
            楼主：<?php echo $data_content['name']?>&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
          </p>
        </div>
        <div class="count">
          <p>
            回复<br /><span>41</span>
          </p>
          <p>
            浏览<br /><span><?php echo $data_content['times']?></span>
          </p>
        </div>
        <div style="clear:both;"></div>
      </li>
    <?php
     }
     ?>
    </ul>
    <div class="pages_wrap">
      <a class="btn publish" href=""></a>
      <div class="pages">
        <a>« 上一页</a>
        <a>1</a>
        <span>2</span>
        <a>3</a>
        <a>4</a>
        <a>...13</a>
        <a>下一页 »</a>
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
            <li><h3><a href="#"><?php echo $data_son['module_name'] ?></a></h3></li>
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
