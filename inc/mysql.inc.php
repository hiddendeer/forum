  <?php
  // require_once 'config.inc.php';
  function connect($host=DB_HOST,$user=DB_USER,$password=DB_PW,$database=DB_DATABASE,$port=DB_PORT){
    $link = @mysqli_connect($host,$user,$password,$database,$port);
    if(mysqli_connect_errno()){
      exit;
    }
    mysqli_set_charset($link,'utf8');
    return $link;
  }
  //执行query语句
  function execute($link,$query){
    $result = mysqli_query($link,$query);
    if(mysqli_errno($link)){
      exit(mysqli_error($link));
    }
    return $result;
  }
  //执行query语句，返回boolean
  function execute_bool($link,$query){
    $bool = mysqli_real_query($link,$query);
    if(mysqli_errno($link)){
      exit(mysqli_error($link));
    }
    return $bool;
  }
  function execute_multi(&$link,&$arr_sqls,&$error){
    $sqls = implode(';',$arr_sqls).';';
    if(mysqli_multi_query($link,$sqls)){
      $data = array();
      $i = 0;//计数
      do{
        if($result = musqli_store_result($link)){
          $data[$i] = mysqli_fetch_all($result);
          mysqli_free_result($result);
        }else
        {
          $data[$i] = null;
        }
        $i++;
        if(!mysqli_more_result($link))break;
      }while(mysqli_next_result($link));
      if($i==count($arr_sqls)){
        return $data;
      }else{
        $error = "sql语句执行失败:<br />&nbsp;数组下标为{$i}的语句：{$arr_sqls[$i]}<br />&nbsp;错误原因：".mysqli_error($link);
        return false;
      }
    }else{
      $error = '执行失败!请检查首条语句是否正确!<br />可能错误的原因:'.mysqli_error($link);
      return false;
    }
  }
  function num($link,$sql_count){
      $result = execute($link,$sql_count);
      $count = mysqli_fetch_row($result);
      return $count[0];
  }
  function escape($link,$data){
      if(is_string($data)){
          return mysqli_real_escape_string($link,$data);
      }
      if(is_array($data)){
          foreach($data as $key=>$val){
            $data[$key] = escape($link,$val);
          }
      }
      return $data;

  }


  function close($link){
      mysqli_close($link);
  }



  ?>
