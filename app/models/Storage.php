<?php

namespace App\Models;

interface Storage{
    function getData($tableName);
    function getDataTitles($tableName);
}
