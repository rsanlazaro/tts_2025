<?php
session_start();
?>

<?php
include "../../../includes/app.php";
$conn = connectDB();

if (isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$password = validate($_POST['password']);

if (empty($password)) {
    header("Location: reports.php?error=Se requiere una contraseña");
    exit();
} else {
    if ($password === 'admin@2025') {
        $_SESSION['super_admin'] = true;
        header("Location: documents_access.php");
        exit();
    } else if ($password === 'crm@45') {
        $_SESSION['admin'] = true;
        header("Location: admin_ok.php");
        exit();
    } else {
        header("Location: reports.php?error=Contraseña incorrecta");
        exit();
    }
}
