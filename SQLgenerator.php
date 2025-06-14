<?php
$columns = [];
for ($i = 1; $i <= 50; $i++) {
    $columns[] = "ADD COLUMN `operador_$i` INT(1) DEFAULT '0' COMMENT ''";
}

// Join all the columns with commas and line breaks
$sql = "ALTER TABLE `tts`.`access_default`\n" . implode(",\n", $columns) . ";";

// Output the SQL so you can use it
echo $sql;
