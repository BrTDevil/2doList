<?php
/*
  add for versioning purposes
*/
function readJSON() {
  return file_get_contents('2do.json');
}

function writeJSON($str) {
  $json = file_put_contents('2do.json', $str);
  echo '<script>document.location.href=document.location.href</script>';
  exit;
}

function display($arr) {
    $opts = '';
    foreach ($arr as $k=>$v) {
        $checked = '';
        if ($v == 'checked') {
          $checked = 'class="checked"';
        }
        $opts .= '<li data-name="'.$k.'" '.$checked.'>'.$k.'</li>';
    }
    $str = '<ul id="myUL">'.$opts.'</ul>';
    return $str;
}

function prepareString($arr) {
  return htmlspecialchars(json_encode($arr));
}

function check($json, $val) {
  $arr = json_decode($json, true);
  foreach($arr as $k=>$v) {
    if ($k == $val) {
      $arr[$k] = 'checked';
    }
  }
  $str = json_encode($arr);
  writeJSON($str);
}

function del($json, $val) {
  $res = [];
  $arr = json_decode($json, true);
  foreach($arr as $k=>$v) {
    if ($k != $val) {
      $res[$k] = $v;
    }
  }
  $str = json_encode($res);
  writeJSON($str);
}

function add($json, $val) {
  $arr = json_decode($json, true);
  $arr[$val]="";
  $str = json_encode($arr);
  writeJSON($str);
}

$strJSON = readJSON();
$arr = json_decode($strJSON, true);

if (isset($_REQUEST['operation'])) {
  $oper = $_REQUEST['operation'];
  switch($oper) {
    case 'check':
      check($_POST['json'], $_POST['title']);
      break;
    case 'add':
      add($_POST['json'], $_POST['title']);
      break;
    case 'del':
      del($_POST['json'], $_POST['title']);
      break;
  }
}