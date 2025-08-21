<?php
$columns = [];
for ($i = 46; $i <= 100; $i++) {
    $columns[] = "ADD COLUMN `recluta_$i` text COMMENT ''";
}

// Join all the columns with commas and line breaks
$sql = "ALTER TABLE `tts`.`access`\n" . implode(",\n", $columns) . ";"; 

// Output the SQL so you can use it
echo $sql;
