<?
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

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style.css">
</head>
<body>

<form id="myDIV" class="header" action="" method="post">
  <h2 style="margin:5px">De înfăptuit AZI</h2>
  <input type="text" id="myInput" name="title" placeholder="Title..." required>
  <button type="submit" class="addBtn">Adauga</button>
  <input type="hidden" id="strJSON" name="json" value="<?=prepareString($arr);?>">
  <input type="hidden" id="operation" name="operation" value="add">
</form>

<?
  echo display($arr);
?>

<script>
  function init() {
    var myNodelist = document.getElementsByTagName("LI");
    var i;
    for (i = 0; i < myNodelist.length; i++) {
      var span = document.createElement("SPAN");
      var txt = document.createTextNode("\u00D7");
      span.className = "close";
      span.appendChild(txt);
      myNodelist[i].appendChild(span);
    }

    var close = document.getElementsByClassName("close");
    var i;
    for (i = 0; i < close.length; i++) {
      close[i].onclick = function() {
        document.getElementById('operation').value = 'del';
        document.getElementById('myInput').value = this.parentNode.getAttribute('data-name');
        document.getElementById('myDIV').submit();
      }
    }

    var list = document.querySelector('ul');
    list.addEventListener('click', function(ev) {
      if (ev.target.tagName === 'LI') {
        document.getElementById('operation').value = 'check';
        document.getElementById('myInput').value = ev.target.getAttribute('data-name');
        document.getElementById('myDIV').submit();
      }
    }, false);
  }
  init();

</script>

</body>
</html>
