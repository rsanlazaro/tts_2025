<?php 

if ($_SESSION['login'] == false) {
    header("Location:index.php");
}

$access = ['super-admin','admin-junior','coordinador','operador','recluta-interno'];

if (!(in_array($_SESSION['type'],$access))) {
    header("Location:../../index.php");
}

?>