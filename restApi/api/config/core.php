<?php
// mostrar el reporting de error
ini_set('display_errors', 1);
error_reporting(E_ALL);
 
// la URL de home
$home_url="http://localhost/api/";
 
// la page que se da en el parametro URL, por defecto es 1
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// número de records por pag
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>