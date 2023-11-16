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

foreach ($columns as $column) {
  echo "<th>" . $column["Field"] . "</th>";
}
echo "</tr>";
foreach ($table as $row) {
  echo "<tr>";
  foreach ($row as $value) {
    echo "<td>" . $value . "</td>";
  }
  echo "</tr>";
}
echo "</table>";
?>
</body>
</html>