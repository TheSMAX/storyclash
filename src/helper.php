<?php

function printr($value, bool $die = false, bool $vardump = false){
    echo('<pre>');
    
        if($vardump == true){
            var_dump($value);
        }else{
            print_r($value);
        }
        if($die == true){
            die();
        }

    echo('</pre>');
}