<?php 
      try {   $conn = new PDO("mysql:host=localhost;dbname=dbKP", "root", "1234567890"); }
      catch (PDOException $e) {  die("Database error: " . $e->getMessage());  }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
<?php
      
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["idStudent"]))
{
    $idStudent =  $_GET["idStudent"];
    $IdGroup   =  $_GET["IdGroup"];
//    static $x = $IdGroup;
    $sql = "SELECT * FROM Student WHERE idStudent = :idStudent";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":idStudent", $idStudent);    
    $stmt->execute();
   
    if($stmt->rowCount() > 0)
    { 
          foreach ($stmt as $row) 
         {
            $Name             = $row["Name"];
            $LastName       = $row["LastName"];
            $TicketNumber = $row["TicketNumber"];
            $IdGroup           = $row["IdGroup"];
         }
         echo "<h3>Зміна даних про студента</h3>
            <form method='post'>
                <input type='hidden' name='idStudent' value='$idStudent' />
                    <p>Внесіть змінені дані:
                    <input type='text' name='Name' value='$Name' />
	   <input type='text' name='LastName' value='$LastName' />
	   <input type='text' name='TicketNumber' value='$TicketNumber' />
                    <input type='submit' value='Підтвердіть збереження змін' />
        	</p>
            </form>";
    }
    else
    {
        echo "Дані про студента не знайдено";
    }
}
elseif   ( isset($_POST["idStudent"]) && isset($_POST["Name"])  
       && isset($_POST["LastName"]) && isset($_POST["TicketNumber"])&& isset($_POST["idStudent"])) 
{
    $idgr =$_POST["IdGroup"];

    $sql = "UPDATE Student SET Name = :Name, LastName = :LastName, TicketNumber = :TicketNumber WHERE idStudent = :idStudent";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":idStudent", $_POST["idStudent"]);
    $stmt->bindValue(":Name", $_POST["Name"]);
    $stmt->bindValue(":LastName", $_POST["LastName"]);
    $stmt->bindValue(":TicketNumber", $_POST["TicketNumber"]);
    $stmt->execute();  

     $sql2 = "SELECT * FROM Student Where idStudent =:idStudent";
     $stmt2 =$conn->prepare($sql2);
     $stmt2->bindValue(":idStudent", $_POST["idStudent"]);       $stmt2->execute();  

           
          foreach ($stmt2 as $row) 
         {
            $IdGroup   = $row["IdGroup"];
         }
          echo 
                "<HTML><HEAD>
          <META HTTP-EQUIV='Refresh' CONTENT='0; URL=StudentShow.php?IdGroup=".$IdGroup." '>   </HEAD></HTML>";
}
else{     echo "Некоректні дані";  }
?>
</body>
</html>