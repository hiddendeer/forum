<?php 
if(mb_strlen($_POST['content'])<3){
    skip($_SERVER['REQUEST_URL'],'回复内容不少于3个字');
}

?>