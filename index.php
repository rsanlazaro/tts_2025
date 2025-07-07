<?php
include 'includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="build/css/app.css" />
<link href="assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include 'includes/templates/header_end.php';
?>

<?php
// Check if the user has a remembered email
$remembered_username = isset($_COOKIE['remembered_username']) ? $_COOKIE['remembered_username'] : '';
?>

<main class="main">
    <div class="d-flex justify-content-between links">
        <div class="baby-cloud-component"> <img src="build/img/icons/babySite.png"> <a href="login.php" class="btn-white">Baby site</a></div>
        <div class="baby-cloud-component"> <img src="build/img/icons/agency.webp"> <a href="login.php" class="btn-white">Agency</a></div>
        <div class="baby-cloud-component"> <img src="build/img/icons/babyCloud.webp"> <a href="login.php" class="btn-white">Baby Cloud</a></div>
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="build/js/bundle.min.js"></script>
</body>

</html>