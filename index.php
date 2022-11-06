<?
  require_once 'vendor/autoload.php';
  use trazvan\ToDo;
  $strJSON = ToDo::readJSON();
  $arr = json_decode($strJSON, true);

  if (isset($_REQUEST['operation'])) {
    $oper = $_REQUEST['operation'];
    switch($oper) {
        case 'check':
          ToDo::check($_POST['json'], $_POST['title']);
          break;
        case 'add':
          ToDo::add($_POST['json'], $_POST['title']);
          break;
        case 'del':
          ToDo::del($_POST['json'], $_POST['title']);
          break;
    }
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="static/style.css">
</head>
<body>

  <form id="myDIV" class="header" action="" method="post">
    <h2 style="margin:5px">De înfăptuit AZI</h2>
    <input type="text" id="myInput" name="title" placeholder="Title..." required>
    <button type="submit" class="addBtn">Adauga</button>
    <input type="hidden" id="strJSON" name="json" value="<?=ToDo::prepareString($arr);?>">
    <input type="hidden" id="operation" name="operation" value="add">
  </form>

  <?php echo ToDo::display($arr); ?>

  <script src="static/main.js"></script>

</body>
</html>
