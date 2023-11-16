<!DOCTYPE html>
<html>
<head> <meta charset="utf-8" /> </head>
<body>
<?php   
 $IdGroup=$_POST["IdGroup"];    $GroupName=$_POST["GroupName"];

if (isset($_POST["Name"]) &&  isset($_POST["LastName"]) && isset($_POST["TicketNumber"])  )
{     
    $Name       =  $_POST ["Name"];     $LastName =  $_POST["LastName"];     $TicketNumber =  $_POST["TicketNumber"];   $IdGroup   =  $_POST["IdGroup"];

    try
    {
        $conn = new PDO("mysql:host=localhost;dbname=dbKP", "root", "1234567890");
        $sql = "INSERT INTO Student (Name, LastName, TicketNumber, IdGroup) VALUES ('$Name', '$LastName', '$TicketNumber', '$IdGroup')";

        $affectedRowsNumber = $conn->exec($sql); 

        if($affectedRowsNumber > 0 )     {       echo "Дані про студента ". $LastName . "  ".$Name." успішно внесені до бази даних";                   }
  
 }
    catch (PDOException $e) {       echo "Database error: " . $e->getMessage();    }
}

?>
<h3>
<?php   echo "Внесення нового студенту у групу ".$GroupName;   ?>   </h3>
<form method="post">


    <p>Новий студент:       
    <input type="text" name="Name"               value= 	 <?php     echo $Name ;    ?>>
    <input type="text" name="LastName"          value= 	 <?php     echo $LastName ;    ?>>
     <input type="text" name="TicketNumber"    value=  <?php     echo $TicketNumber ;    ?>>
    <input type="hidden" name="IdGroup"      value= 	 <?php     echo $IdGroup ;    ?>     >
    <input type="submit" value="Зберегти дані"> </p>   
</form>
<form action='StudentShow.php' method='get'>     <input type="hidden" name="IdGroup"        value=	    <?php	     echo $IdGroup ; ?>  />
<input type='submit' value='Повернутися до списку студентів групи'>   </form>
</body>
</html>