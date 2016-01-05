<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 04.01.16
 * Time: 18:40
 */
class view
{
    protected $_file;
    protected $_data = array();

    public function __construct($template)
    {
        $file = 'template/'.$template.'.tpl';
        if (file_exists($file)){$this->_file = $file;}
        else {throw new Exception("Template".$file."nie istnieje.");}
    }

    public function __set($key, $value)
    {
        $this->_data[$key]=$value;
    }

    public function __get($key)
    {
        return $this->_data[$key];
    }

    public function __toString()
    {
        extract($this->_data);
        ob_start();
        include($this->_file);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}