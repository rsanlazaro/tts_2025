<?php
// Make sure the response is plain text (not HTML)
header('Content-Type: text/plain');

// Read the raw POST body
$input = json_decode(file_get_contents('php://input'), true);

// Extract values
$id = $input['id'] ?? 'No ID';
$content = $input['content'] ?? 'No Content';
$stage = $input['stage'] ?? 'No Stage';
$row_number = $input['row'] ?? 'No Row';
$row_max = $input['row_max'] ?? 'No max value';

include "includes/app.php";
$conn = connectDB();
$table = "ipregister_" . $stage;

$sql = "SELECT * FROM $table WHERE id=1";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 5; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
    }
}

if ($row_number > 0) {
    if ($content == "false") {
        ${"stage_count_$row_number"} = ${"stage_count_$row_number"} - 1;
        if (${"stage_count_$row_number"} == 1) {
            $content = "true";
        }
    } else {
        ${"stage_count_$row_number"} = ${"stage_count_$row_number"} + 1;
        if (${"stage_count_$row_number"} == $row_max) {
            $content = "false";
        }
    }
    $variable = "stage_count_" . $row_number;
    $variableValue = ${"stage_count_$row_number"};
    $sql = "UPDATE $table SET $variable=$variableValue WHERE id=1";
    mysqli_query($conn, $sql);
}

$variable = "stage_" . $id;
$sql = "UPDATE $table SET $variable='$content' WHERE id=1";
mysqli_query($conn, $sql);

// Echo the data back
echo "Received ID: $id with table $table \n variable $variable Received Content: $content from stage $stage and row_number $row_number";