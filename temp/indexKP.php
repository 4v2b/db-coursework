<!DOCTYPE html>
<html>
<head>
  <title>SE 603 реляційні бази даних курсовий проєкт</title>
  <meta charset="utf-8" />
</head>
<body>
<h2>Студентські групи </h2>
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=dbkp", "root", "1234567890");
    $sqlStudentGroup = "SELECT * FROM studentGroup";
    $resultStudentGroup = $conn->query($sqlStudentGroup);
//+++++++++++++++++++++++++++++++++
 echo "<table>
       <tr><th>код Групи  </th><th> Номер групи </th></tr>";
    foreach($resultStudentGroup as $row){
        echo "<tr>";
            echo "<td>" . $row["IdGroup"] . "</td>";
            echo "<td>" . $row["GroupName"] . "</td>";
            echo "<td><form action='StudentGroupDelete.php' method='post'>
                               <input type='hidden' name='IdGroup' value='" . $row["IdGroup"] . "' />
                               <input type='submit' value='Вилучити групу '>
                             </form></td>";
            echo "<td><a href='StudentGroupUpdate.php?IdGroup=" . $row["IdGroup"] . "'>Змінити назву групи</a></td>";
//            echo "<td><a href='StudentShow.php?IdGroup=" . $row["IdGroup"] . "'>Студенти цієї групи </a></td>";

 echo "<td><a href='StudentShow.php?IdGroup=" . $row["IdGroup"] . "'>Список студентів групи</a></td>";
        echo "</tr>";
    }

$msgnew ='Додати  групу';
      echo "<td><form action='StudentGroupInsert.php' method='post'> 
            	  <input type='submit' value='$msgnew'> 
				</form></td>";

    echo "</table>";

}
catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
</body>
</html>
