<?php

include_once('db.php');
include_once('model.php');
include_once('test.php');

$conn = get_connect();
// init_db($conn);

// Uncomment to see data in db
// run_db_test($conn);
  
$month_names = [
    '01' => 'January',
    '02' => 'February',
    '03' => 'March'
]
?>
    
<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Informacja o transakcjach użytkownika</title>
  <link rel="stylesheet" href="./css/style.css">
</head>
<body>
  <h1>Informacja o transakcjach użytkownika</h1>
  <form action="data.php" method="get">
    <label for="user">Wybierz użytkownika:</label>
    <select name="user" id="user">
    <?php
    $users = get_users($conn);
    foreach ($users as $id => $name) {
        echo "<option value=\"$id\">".$name."</option>";
    }
    ?>
    </select>
    <input id="submit" type="submit" value="Wyświetl">
  </form>

  <div id="data">
      <h2>Transakcje `User name`</h2>
      <table>
          <tr><th>Miesiąc</th><th>Saldo</th></tr>
      </table>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="./js/script.js"></script>
</body>
</html>
