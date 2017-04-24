<?php

//print PHP_EOL;
foreach (glob(__DIR__ . "/../migrations/*.php") as $filename)
{
    //print PHP_EOL;
    print PHP_EOL;
    print $filename .PHP_EOL;
    (require_once $filename)->migrate();
}