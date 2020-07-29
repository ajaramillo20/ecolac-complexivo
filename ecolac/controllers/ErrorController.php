<?php

class ErrorController
{

    public function index($msg = '')
    {
        if ($msg == '') {
            echo "<h1>La página que buscas no existe</h1>";
        } else {
            echo "<h1>" . $msg . "</h1>";
        }
    }
}
