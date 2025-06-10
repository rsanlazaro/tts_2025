<?php
include '../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../build/css/app.css" />
<link href="../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../includes/templates/header_end.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<main class="baby-sites-home">
    <div class="d-flex justify-content-start"> <a href="../../index.php"> <img src="../../build/img/logos/TTS.webp" alt="tts logo"> </a> </div>
    <h2>Menú de Sites</h2>
    <div class="d-flex justify-content-center">
        <a href=<?php echo "dashboard.php?user=" . $_SESSION['id'] ?> > <img src="../../build/img/logos/babySite.webp" alt="babySite logo"> </a>
        <a href="#"> <img src="../../build/img/logos/babyCloud.webp" alt="babyCloud logo"> </a>
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="build/js/bundle.min.js"></script>
</body>

</html>