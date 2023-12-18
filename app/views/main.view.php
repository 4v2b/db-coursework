<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Головна</title>
</head>

<body>
  <?php

  //$table = $storage->getDataFromTable("city");
  //$columns = $storage->getColumnNames("city");

  echo "<table><tr>";

  // foreach ($columns as $column) {
  //   echo "<th>" . $column["Field"] . "</th>";
  // }
  // echo "</tr>";
  // foreach ($table as $row) {
  //   echo "<tr>";
  //   foreach ($row as $value) {
  //     echo "<td>" . $value . "</td>";
  //   }
  //   echo "</tr>";
  // }

  foreach ($rows[0] as $column => $val) {
    echo "<th>" . $column . "</th>";
  }

  echo "</tr>";
  foreach ($rows as $row) {
    echo "<tr>";
    foreach ($row as $value) {
      echo "<td>" . $value . "</td>";
    }

    echo "<td><form method='POST' action='{$root}/{$role}/{$tableName}/delete'>";
    foreach ($row as $key => $value1) {
      echo  "<input type='hidden' value='{$value1}' name='{$key}' ></input>";
    }
    echo "<input type='submit' value='Видалити'></input></form></td>";

    echo "<td><button>Редагувати</button></td>";
    echo "</tr>";
  }
  echo "<tr>";
  echo "<form method='POST' action='{$root}/{$role}/{$tableName}/add'>";
  foreach($types as $fieldName => $type){
    echo "<td>";

    echo  "<input required type='{$type}' name='{$fieldName}' ></input>";

    echo "</td>";

  }
  echo "<td colspan='2'>";

  echo "<input type='submit' value='Додати'></input></form></td>";
  echo "</form>";
  echo "</td>";
  echo "</tr>";

  echo "</table>";
  ?>



</body>

</html>