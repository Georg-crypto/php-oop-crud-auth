<?php

    spl_autoload_register(function ($class) {
       $dirs = ['components', 'controllers', 'models'];
       foreach ($dirs as $dir) {
           $filename = "$dir/" . mb_strtolower($class) . ".php";
           if (file_exists($filename)) {
              require_once($filename);
           }
       }
    });
