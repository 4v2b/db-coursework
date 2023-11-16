<?php
echo "start student delete: idStudent=".$_POST["idStudent"]."  IdGroup=".$_POST["IdGroup"];

if(isset($_POST["idStudent"]) && isset($_POST["IdGroup"]) )
{
   try {
        $connect = new PDO("mysql:host=localhost;dbname=dbKP", "root", "1234567890");
        $sql = "DELETE FROM Student WHERE idStudent = :idStudent and IdGroup=:IdGroup";		
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(":IdGroup", $_POST["IdGroup"]);
        $stmt->bindValue(":idStudent", $_POST["idStudent"]);
        $stmt->execute();		     
        header("Location: indexKP.php");
        echo "<HTML><HEAD><META HTTP-EQUIV='Refresh' CONTENT='0; URL=StudentShow.php?IdGroup=".$_POST['IdGroup']."'>
        </HEAD></HTML>";
       }
    catch (PDOException $e) {   echo "Database error: " . $e->getMessage();   }
}
echo "finish student delete";  exit("stop");
?>
