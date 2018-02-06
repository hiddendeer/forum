<?php
include_once '../inc/mysql.inc.php';
include_once '../inc/config.inc.php';
$link = connect();
$query = "select * from father_module;";
$result = execute($link,$query);

// $arr = mysqli_fetch_assoc($result);
//var_dump($_SERVER);
?>
<?php include 'inc/header.inc.php' ?>
<div id="main" style="height:1000px;">
    <div class="title">父板块</div>
    <!--    <div class="explain">-->
    <!--        <ul>-->
    <!--            <li>1. 嘿嘿</li>-->
    <!--            <li>2. 嘿嘿</li>-->
    <!--            <li>3. 嘿嘿</li>-->
    <!--        </ul>-->
    <!--    </div>-->
    <table class="list">
        <tr>
            <th>排序</th>
            <th>版块名称</th>
            <th>操作</th>
        </tr>
        <?php
        $query = "select*from sfk_father_module";
        $result = execute($link, $query);
        while ($data = mysqli_fetch_assoc($result)) {
            $url = urlencode("father_module.delete.php?id={$data['id']}");
            $return_url = urlencode($_SERVER['REQUEST_URI']);
            $message = "你真的要删除父版块{$data['module_name']}";
            $delete_url = "confirm.php?url={$url}&return_url={$return_url}&message={$message}";
            $html = <<<A
        <tr>
            <td><input class="sort" type="text" name="sort" /></td>
            <td>{$data['module_name']}[id:{$data['id']}]</td>
            <td><a href="#">[访问]</a>&nbsp;&nbsp;<a href="#">[编辑]</a>&nbsp;&nbsp;<a href="$delete_url">[删除]</a></td>
        </tr>

A;
            echo $html;

        }

        ?>


    </table>


</div>
<?php include 'inc/footer.inc.php' ?>
