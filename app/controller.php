<?php

require_once(__DIR__ . "/model/Storage.php");
require_once(__DIR__ . "/config.php");

$connection = new mysqli($SERVER, $USER, $PASSWORD, $DATABASE);

$storage = new Storage($connection);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $tableName =  $_GET["table"];
    $table = $storage->getDataFromTable($tableName);
    $columns = $storage->getColumnNames($tableName);
    require(__DIR__."/views/main.view.php");
}

?>