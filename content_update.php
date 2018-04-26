<?php 
include_once 'inc/config.inc.php';
include_once 'inc/mysql.inc.php';
include_once 'inc/tool.inc.php';
$link=connect();
if(!$member_id=is_login($link)){
	skip('login.php','请没有登录!');
}
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
	skip('index.php','帖子id参数不合法!');
}
$query="select * from content where id={$_GET['id']}";
$result_content=execute($link, $query);
if(mysqli_num_rows($result_content)==1){
	$data_content=mysqli_fetch_assoc($result_content);
	$data_content['title']=htmlspecialchars($data_content['title']);
	if(check_user($member_id,$data_content['member_id'])){
		if(isset($_POST['submit'])){
			include 'inc/check_publish.inc.php';
			$query="update content set module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' where id={$_GET['id']}";
			execute($link, $query);
			if(mysqli_affected_rows($link)==1){
				skip("member.php?id={$member_id}",'修改成功！');
			}else{
				skip("member.php?id={$member_id}", '修改失败，请重试！');
			}
		}
	}else{
		skip('index.php','这个帖子不属于你，你没有权限!');
	}
}else{
	skip('index.php','帖子不存在!');
}
$template['title']='帖子修改页';
$template['css']=array('style/public.css','style/publish.css');
?>
<?php include 'inc/header.inc.php'?>
<div id="position" class="auto">
	 <a href="index.php">首页</a> &gt; 发布帖子
</div>
<div id="publish">
	<form method="post">
		<select name="module_id">
			<option value='-1'>请选择一个子版块</option>
			<?php 
			$query="select * from father_module order by sort desc";
			$result_father=execute($link, $query);
			while ($data_father=mysqli_fetch_assoc($result_father)){
				echo "<optgroup label='{$data_father['module_name']}'>";
				$query="select * from son_module where father_module_id={$data_father['id']} order by sort desc";
				$result_son=execute($link, $query);
				while ($data_son=mysqli_fetch_assoc($result_son)){
					if($data_son['id']==$data_content['module_id']){
						echo "<option selected='selected' value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}else{
						echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
					}
				}
				echo "</optgroup>";
			}
			?>
		</select>
		<input class="title" placeholder="请输入标题" value="<?php echo $data_content['title']?>" name="title" type="text" />
		<textarea name="content" class="content"><?php echo $data_content['content']?></textarea>
		<input  type="submit" name="submit" value="回复" />
		<div style="clear:both;"></div>
	</form>
</div>
<?php include 'inc/footer.inc.php'?>