<?php 

if ($_SESSION['login'] == false) {
    header("Location:index.php");
}

$access = ['super_admin','admin_junior','coordinador','operador','recluta'];

if (!(in_array($_SESSION['type'],$access))) {
    header("Location:/index.php");
}

?>