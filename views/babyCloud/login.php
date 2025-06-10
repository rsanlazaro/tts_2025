<?php
include '../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../build/css/app.css" />
<link href="../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../includes/templates/header_end.php';
?>

<?php
// Check if the user has a remembered email
$remembered_username = isset($_COOKIE['remembered_username']) ? $_COOKIE['remembered_username'] : '';
?>

<main class="login">
    <header class="d-flex justify-content-start align-items-center">
        <div class="logo">
            <a href="../../index.php"><img src="../../build/img/logos/TTS.webp" alt="TTS logo"></a>
        </div>
    </header>
    <?php if (isset($_GET['error'])) { ?>
        <p class="error"><?php echo $_GET['error']; ?></p>
    <?php } ?>
    <div class="login-form">
        <form class="pink-form" action="../../validate.php" method="POST">
            <input type="hidden" name="section" value='<?php echo "babyCloud"; ?>' />
            <div class="col-md-12">
                <input class="form-control" type="text" name="username" placeholder="Usuario" value="<?php echo htmlspecialchars($remembered_username); ?>" required />
            </div>
            <div class="col-md-12">
                <input class="form-control" type="password" name="password" placeholder="Contraseña" required />
            </div>
            <label class="form-check-label">
                <input type="checkbox" name="remember_me" <?php if (isset($remembered_username)) {
                                                                echo 'checked';
                                                            } ?>>
                Recuérdame
            </label><br>
            <div class="form-btn d-flex justify-content-center">
                <button class="btn btn-pink btn-send" type="submit">
                    <div>Login</div>
                </button>
            </div>
        </form>
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="build/js/bundle.min.js"></script>
</body>

</html>