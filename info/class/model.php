<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 04.01.16
 * Time: 20:37
 */
class model
{
    private $table = array();

    function __construct()
    {
        $this->table['main'] = 'index.php';
        $this->table['info'] = 'zawiera rzeczy z katalogu info';
        $this->table['baza'] = 'zawiera rzeczy zwiazane z bazą';
    }

    public function getTable()
    {
        return $this->table;
    }
}

