<?php 
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';

$link=connect();
include_once 'inc/is_manage_login.inc.php';//验证管理员是否登录
if(isset($_POST['submit'])){
	//验证用户填写的信息
	$check_flag='add';
	// include 'inc/check_son_module.inc.php';
	// $query="insert into son_module(father_module_id,module_name,info,member_id,sort) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
	// include 'inc/check_son_module.inc.php';
	$query = "insert into son_module(father_module_id,module_name,info,sort) values ({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['sort']})";
	execute($link,$query);
	if(mysqli_affected_rows($link)==1){
		skip('son_module.php','恭喜你，添加成功！');
	}else{
		skip('son_module_add.php','对不起，添加失败，请重试！');
	}
}
$template['title']='小话题添加页';
$template['css']=array('style/public.css');
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
	<div class="title" style="margin-bottom:20px;">添加小话题</div>
	<form method="post">
		<table class="au">
			<tr>
				<td>所属大话题</td>
				<td>
					<select name="father_module_id">
						<option value="0">======请选择一个大话题======</option>
						<?php 
						$query="select * from father_module";
						$result_father=execute($link,$query);
						while ($data_father=mysqli_fetch_assoc($result_father)){
							echo "<option value='{$data_father['id']}'>{$data_father['module_name']}</option>";
						}
						?>
					</select>
				</td>
				<td>
					必须选择一个所属的大话题
				</td>
			</tr>
			<tr>
				<td>话题名称</td>
				<td><input name="module_name" type="text" /></td>
				<td>
					话题名称不得为空，最大不得超过66个字符
				</td>
			</tr>
			<tr>
				<td>话题简介</td>
				<td>
					<textarea name="info"></textarea>
				</td>
				<td>
					简介不得多于255个字符
				</td>
			</tr>
			<!-- <tr>
          <td>版主</td>
          <td>
             <select name="member_id">
               <option value="0">===选择一个会员为版主</option>
             </select>
          </td>
          <td>
            选一个会员作为版主
          </td>
        </tr> -->
			<tr>
				<td>排序</td>
				<td><input name="sort" value="0" type="text" /></td>
				<td>
					填写一个数字即可
				</td>
			</tr>
		</table>
		<input style="margin-top:20px;cursor:pointer;" class="btn" type="submit" name="submit" value="添加" />
	</form>
</div>
<?php include 'inc/footer.inc.php'?>