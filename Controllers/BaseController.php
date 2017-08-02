<?php

namespace Controllers;

class BaseController
{
    public function __toString(){
        $result = substr(get_class($this), 12);
        return substr($result, 0, strpos($result, "Controller"));
    }
}