<?php
$kasutaja='d123187_maksimts';
$serverinimi='d123187.mysql.zonevs.eu';
$parool='0b3z8OhUXNCt';
$andmebaas='d123187_database';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');