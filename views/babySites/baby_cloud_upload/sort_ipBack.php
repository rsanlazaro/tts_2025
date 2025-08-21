<?php
// Make sure the response is plain text (not HTML)
header('Content-Type: text/plain');

include "../../../includes/app.php";
$conn = connectDB();

// Read the raw POST body
$input = json_decode(file_get_contents('php://input'), true);

$action = $input['action'] ?? 'No Action';
$stage = $input['stage'] ?? 'No Stage';

if ($action == 'add' || $action == 'remove') {
    $id_ip = $input['id_ip'] ?? 'No id_ip value';
    $sql = "SELECT * FROM ipregister_1 WHERE id=$id_ip";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $stage_count = $row['stage_count_' . $stage];
    }
    $variable = "stage_count_" . $stage;
    if ($action == 'add') {
        $content = $stage_count + 1;
    } else {
        $content = $stage_count - 1;
    }
    $sql = "UPDATE ipregister_1 SET $variable='$content' WHERE id=$id_ip";
    mysqli_query($conn, $sql);
} else {
    // Extract values
    $id = $input['id'] ?? 'No ID';
    $content = $input['content'] ?? 'No Content';
    $stage = $input['stage'] ?? 'No Stage';
    $row_number = $input['row'] ?? 'No Row';
    $row_max = $input['row_max'] ?? 'No max value';
    $id_ip = $input['id_ip'] ?? 'No id_ip value';

    $table = "ipregister_" . $stage;
    if ($table == "ipregister_2") {
        $table = "ipregister_2_2";
    }

    // $sql = "SELECT * FROM $table WHERE id=$id_ip";
    // $result = mysqli_query($conn, $sql);
    // while ($row = mysqli_fetch_assoc($result)) {
    //     for ($i = 1; $i <= 8; $i++) {
    //         ${"stage_count_$i"} = $row['stage_count_' . $i];
    //     }
    // }

    // if ($row_number > 0) {
    //     if ($content == "false") {
    //         ${"stage_count_$row_number"} = ${"stage_count_$row_number"} - 1;
    //         if (${"stage_count_$row_number"} == 1) {
    //             $content = "true";
    //         }
    //     } else {
    //         ${"stage_count_$row_number"} = ${"stage_count_$row_number"} + 1;
    //         if (${"stage_count_$row_number"} == $row_max) {
    //             $content = "false";
    //         }
    //     }
    //     $variable = "stage_count_" . $row_number;
    //     $variableValue = ${"stage_count_$row_number"};
    //     $variableValue == 0 ? $variableValue = 1 : $variableValue;
    //     $sql = "UPDATE $table SET $variable=$variableValue WHERE id=$id_ip";
    //     mysqli_query($conn, $sql);
    // }

    $variable = "stage_" . $id;
    if ($table == "ipregister_2_2") {
        if ($id <= 157) {
            $table = "ipregister_2";
        }
    }
    $sql = "UPDATE $table SET $variable='$content' WHERE id=$id_ip";
    mysqli_query($conn, $sql);

    // Echo the data back
    echo "Received ID: $id_ip with table $table \n variable $variable Received Content: $content from stage $stage and row_number $row_number";
}
