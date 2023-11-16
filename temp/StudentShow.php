<!DOCTYPE html>
<html>
<head>
<title>se 603</title>
<meta charset="utf-8" />
</head>
<body>
<?php
try {   $conn = new PDO("mysql:host=localhost;dbname=dbKP", "root", "1234567890"); }
catch (PDOException $e) {  die("Database error: " . $e->getMessage());}
if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["IdGroup"]))
{
    $IdGroup   = $_GET["IdGroup"];	
    $sqlGroup  = "SELECT * FROM StudentGroup WHERE IdGroup = $IdGroup ";

    $stmtGroup = $conn->prepare($sqlGroup);
    $stmtGroup->bindValue(":GroupName",     $GroupName);
    $stmtGroup->bindValue(":IdGroup",     $IdGroup);
    $stmtGroup = $conn->prepare($sqlGroup);

    $stmtGroup->execute();
    if($stmtGroup->rowCount() > 0)
    {
        foreach ($stmtGroup as $row)   {    $GroupName    = $row["GroupName"];       }
    }
              $GroupName    = $row["GroupName"];    

    $sql = "SELECT * FROM Student WHERE IdGroup = $IdGroup";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(":idStudent",  $idStudent);
    $stmt->bindValue(":Name",        $Name);
    $stmt->bindValue(":LastName",        $LastName);
    $stmt->bindValue(":TicketNumber",        $TicketNumber);
    $stmt->bindValue(":IdGroup",          $IdGroup);
	
    $stmt->execute();

    if($stmt->rowCount() > 0)
    {
        echo "<h3>Студенти групи: ". $GroupName.   "</h3>";  
        echo "<table>";

        foreach ($stmt as $row) 
        { 
            $Name              = $row["Name"];
            $LastName        = $row["LastName"];
            $TicketNumber = $row["TicketNumber"];             
            $idStudent         = $row["idStudent"];
            $IdGroup          = $row["IdGroup"];
              echo "<tr>";
	 echo "<td><form action='StudentDelete.php' method='post'>
	            <input type='hidden' name='IdGroup' value='" . $row["IdGroup"] . "' />    
	            <input type='hidden' name='idStudent' value='".$row["idStudent"] ."' />                                                                                               
                            <input type='submit' value='Вилучити'>
                    </form></td>";										 
              echo "<td><form action='StudentUpdate.php'     method='get'>
                   <input type='hidden' name='idStudent' value='$idStudent' />
                     ім'я студента: <input type='text' name='Name' value='$Name' />
                     прізвище студента:     <input type='text' name='LastName' value='$LastName'/>
                     номер студентського :     <input type='text' name='TicketNumber' value='$TicketNumber'/>
                                   <input type='hidden' name='IdGroup' value='$IdGroup' />    
                   <input type='submit' value='Змінити дані про студента' />                   
                   </form></td>"; 
            echo "</tr>";
        }
        echo "</table>";
    }
   echo "<table> ";
  $stmt->execute();
       if ($stmt->rowCount() > 0)$buttonText ='Додати нового студента'; else $buttonText ='Створити першого студента у групі';
          echo "<td><form action='StudentInsert.php' method='post'>
                 <input type='hidden' name='IdGroup' value='$IdGroup' />   
                 <input type='hidden' name='GroupName' value='$GroupName' />                  
                 <input type='submit' value='$buttonText'> </form></td>";
		  echo "<td><form action='indexKP.php' method='post'>                 
                 <input type='submit' value='Повернутися до списку груп'> </form></td>";
        echo "</table>";
}
elseif (isset($_POST["idStudent"]) && isset($_POST["Name"]) && isset($_POST["LastName"])&&
          isset($_POST["TicketNumber"])) 
{    
   $Name            = $_POST["Name"];
   $LastName     = $_POST["LastName"];
   $idStudent     = $_POST["idStudent"];
   $TicketNumber    = $_POST["TicketNumber"];
   $idGroup       = $_POST["idGroup"];
   $conn = new PDO("mysql:host=localhost;dbname=dbKP", "root", "1234567890");
   $sqlStudentUpdate = "UPDATE Student SET Name = '$Name', LastName = '$LastName', TicketNumber ='$TicketNumber'
 WHERE  idStudent = $idStudent AND idGroup = $idGroup";
   echo " POST:sqlStudentUpdate= ".$sqlStudentUpdate;
    $result = $conn->query($sqlStudentUpdate);
    echo " POST after query!!!!";
    header("Location: indexKP.php");
}
if (isset($_POST["ExitName"]) ) { exit();}
//else{  echo "Некоректні дані  Student show";}
?>
</body>
</html>