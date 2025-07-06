<?php
$columns = [];
for ($i = 201; $i <= 286; $i++) {
    $columns[] = "ADD COLUMN `stage_$i` text DEFAULT '-' COMMENT ''";
}

// Join all the columns with commas and line breaks
$sql = "ALTER TABLE `tts`.`ipregister_5`\n" . implode(",\n", $columns) . ";";

// Output the SQL so you can use it
echo $sql;
