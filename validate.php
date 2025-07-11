<?php
session_start();
?>

<?php
include "includes/app.php";
$conn = connectDB();

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

$username = validate($_POST['username']);
$password = validate($_POST['password']);
$remember = isset($_POST['remember_me']);
$section = $_POST['section'];

if (empty($username)) {
    header("Location: index.php?error = User Name is required");
    exit();
} else if (empty($password)) {
    header("Location: index.php?error = Password is required");
    exit();
} else {
    $sql = "SELECT * FROM guests WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row == NULL) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if ($row['username'] != '-') {
            if ($password === $row['password']) {
                $auth = 1;
            }
            if (mysqli_num_rows($result) === 1) {

                if ($row['username'] === $username && $auth && $row['enabled'] == 'true') {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $row['profile'];
                    $_SESSION['user'] = $row['username'];
                    if ($remember) {
                        // Set a cookie for 30 days
                        setcookie('remembered_username', $username, time() + (30 * 24 * 60 * 60));
                    } else {
                        // Clear the cookie
                        setcookie('remembered_username', '', time() - 3600);
                    }
                    header("Location: views/babySites/home.php?user=" . $_SESSION['id']);
                    exit();
                } else {
                    header("Location:login.php?error=Usuario o contraseña incorrecta");
                    exit();
                }
            } else {
                header("Location:login.php?error=Usuario o contraseña incorrecta");
                exit();
            }
        } else {
            header("Location:login.php?error=Usuario o contraseña incorrecta");
            exit();
        }
    } else {
        if ($row['username'] != '-') {
            if ($password === $row['password']) {
                $auth = 1;
            }
            if (mysqli_num_rows($result) === 1) {

                if ($row['username'] === $username && $auth && $row['enabled'] == 'true') {
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['login'] = true;
                    $_SESSION['type'] = $row['profile'];
                    $_SESSION['user'] = $row['username'];
                    if ($remember) {
                        // Set a cookie for 30 days
                        setcookie('remembered_username', $username, time() + (30 * 24 * 60 * 60));
                    } else {
                        // Clear the cookie
                        setcookie('remembered_username', '', time() - 3600);
                    }
                    header("Location: views/babyCloud/home.php");
                    exit();
                } else {
                    header("Location:login.php?error=Usuario o contraseña incorrecta");
                    exit();
                }
            } else {
                header("Location:login.php?error=Usuario o contraseña incorrecta");
                exit();
            }
        } else {
            header("Location:login.php?error=Usuario o contraseña incorrecta");
            exit();
        }
    }
}
