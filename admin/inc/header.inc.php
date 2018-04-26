<?php 

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title><?php echo $template['title'] ?></title>
<meta name="keywords" content="后台界面" />
<meta name="description" content="后台界面" />
<?php 
foreach ($template['css'] as $val){
	echo "<link rel='stylesheet' type='text/css' href='{$val}' />";
}
?>
</head>
<body>
<div id="top">
	<div class="logo">
		后台管理
	</div>
	<div class="login_info">
		管理账号：<?php echo $_SESSION['manage']['name']?> <a href="logout.php">[注销]</a>
	</div>
</div>
<div id="sidebar">
	<ul>
		<li>
			<div class="small_title">系统</div>
			<ul class="child">
				<!-- <li><a href="#">系统信息</a></li> -->
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='manage.php'){echo 'class="current"';}?> href="manage.php">管理员</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){echo 'class="current"';}?> href="manage_add.php">添加管理员</a></li>
				<!-- <li><a href="#">站点设置</a></li> -->
			</ul>
		</li>
		<li><!--  class="current" -->
			<div class="small_title">内容管理</div>
			<ul class="child">
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module.php'){echo 'class="current"';}?> href="father_module.php">大话题列表</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='father_module_add.php'){echo 'class="current"';}?> href="father_module_add.php">添加大话题</a></li>
				<?php 
				if(basename($_SERVER['SCRIPT_NAME'])=='father_module_update.php'){
					echo '<li><a class="current">编辑大话题</a></li>';
				}
				?>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module.php'){echo 'class="current"';}?> href="son_module.php">小话题列表</a></li>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='son_module_add.php'){echo 'class="current"';}?> href="son_module_add.php">添加小话题</a></li>
				<?php 
				if(basename($_SERVER['SCRIPT_NAME'])=='son_module_update.php'){
					echo '<li><a class="current">编辑小话题</a></li>';
				}
				?>
				<li><a <?php if(basename($_SERVER['SCRIPT_NAME'])=='topics.php'){echo 'class="current"';}?> href="./topics.php">话题管理</a></li>
			</ul>
		</li>
		<!-- <li>
			<div class="small_title">用户管理</div>
			<ul class="child">
				<li><a href="#">用户列表</a></li>
			</ul>
		</li> -->
	</ul>
</div>