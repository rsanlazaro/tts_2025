<?php 
function connectDB() : mysqli{
    
    $db = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'] ?? '',
        $_ENV['DB_BD']);

    if(!$db) {
        // echo "Error, no se pudo conectar";
        exit;
    } else {
        // echo "se pudo conectar";
    }

    return $db;
}

?>