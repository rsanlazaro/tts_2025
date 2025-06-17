<?php
// Make sure the response is plain text (not HTML)
header('Content-Type: text/plain');

// Read the raw POST body
$input = json_decode(file_get_contents('php://input'), true);

// Extract values
if (isset($_POST['function'])) {
    $function = $_POST['function'];
} else {
    $function = $input['function'] ?? 'No function value';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../includes/app.php";
    $conn = connectDB();

    if ($function == 'toggleAccess') {
        $id = $input['id'] ?? 'No id value';
        $newValue = $input['newValue'] ?? 'No newValue value';
        $column = $input['column'] ?? 'No column value';
        if (isset($id)) {
            $query = "UPDATE access SET $column = '${newValue}' WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'deleteSelected') {
        $page = $input['page'];
        $ids = $input['id'];
        $idsSQL = '(';
        $count = 0;
        foreach ($ids as $id) {
            $count++;
            if ($count > 1) {
                $idsSQL = $idsSQL . ', ';
            }
            $idsSQL = $idsSQL . filter_var($id, FILTER_VALIDATE_INT);
        }
        $idsSQL = $idsSQL . ')';
        if (isset($ids)) {
            $query = "DELETE FROM $page WHERE id IN ${idsSQL}";
            echo "Query: $query\n";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'delete') {
        $page = $input['page'];
        $id = $input['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (isset($id)) {
            $query = "DELETE FROM $page WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
    }

    if ($function == 'insert') {
        $page = $input['page'];
        $today = date("Y-m-d H:i:s");
        $sql = "INSERT INTO $page (username, password, created_on)
        VALUES ('-', '-', '${today}');";
        $result = mysqli_query($conn, $sql);
    }

    if ($function == 'update') {
        $page = $input['page'];
        $id = $input['id'] ?? 'No id value';
        $newValue = $input['newValue'] ?? 'No newValue value';
        $column = $input['column'] ?? 'No column value';
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (isset($id)) {
            $query = "UPDATE $page SET $column = '${newValue}' WHERE id = ${id}";
            $result = mysqli_query($conn, $query);
        }
        echo "Received ID: $id with column $column and newValue $newValue from page $page";
    }
}
