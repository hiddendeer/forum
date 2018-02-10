<?php
function skip($url,$message) {
  $html = <<<A
  <!DOCTYPE html>
  <html lang="zh-CN">
  <head>
  <meta charset="utf-8" />
  <meta http-equiv="refresh" content="3;URL = {$url}" />
  <title>正在跳转</title>
  <link rel="stylesheet" type="text/css" href="style/remind.css" />
  </head>
  <body>
  <div class="notice"><span class="pic ask"></span>{$message}<a href="{$url}">3秒后自动跳转</a></div>
  </body>
  </html>
A;
echo $html;
}

 ?>
