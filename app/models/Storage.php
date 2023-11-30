<?php

namespace App\Models;

interface Storage{
    function fetch($tableName);
}
