<?php
include '../../../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../../../build/css/app.css" />
<link href="../../../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../../../includes/templates/header_end.php';
include '../../../../includes/app.php';
include '../../../../includes/templates/sessionStart.php';
include '../../../../includes/templates/validateAccessInternal.php';

// For access information

$id_user = $_SESSION['id'];
$sql = "SELECT * FROM users WHERE id=${id_user}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $username_user = $row['username'];
    for ($i = 1; $i <= 100; $i++) {
        ${'access_' . $i} = $row['access_' . $i];
    }
}

if ($access_21 < 1) {
    header("Location: ../../../../index.php?error=Acceso denegado");
    exit();
}

$id_user = $_GET['user'] ?? $_SESSION['id'] ?? null;

$sql = "SELECT * FROM users WHERE id=${id_user}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $username_user = $row['username'];
}

$username_user_trimmed = trim($username_user);
if (str_contains($username_user_trimmed, ' ')) {
    if (preg_match('/\S+\s+\S+/', $username_user_trimmed)) {
        $words_user = preg_split('/\s+/', $username_user_trimmed);
        $last_name_user = '';
        for ($i = 0; $i < count($words_user); $i++) {
            if ($i == 0) {
                $name_user = ucfirst(strtolower($words_user[$i]));
            } else {
                $last_name_user .= ucfirst(strtolower($words_user[$i])) . ' ';
            }
        }
    }
} else {
    $name_user = $username_user_trimmed;
    $last_name_user = "";
}

$dt = new DateTime('now', new DateTimeZone('UTC'));
$dt->modify('-6 hours'); // Manual offset for Mexico City

// For users fetch information

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $id[++$index] = $row['id'];
    $user[$index] = $row['username'];
    $mail[$index] = $row['mail'];
    $pass[$index] = $row['password'];
    $profile[$index] = $row['profile'];
    $enabled[$index] = $row['enabled'];
    $created_on[$index] = $row['created_on'];
}

// For access_default fetch information 

$sql = "SELECT * FROM access WHERE id=1";
$result = mysqli_query($conn, $sql);
$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 100; $i++) {
        $column_db = 'super_admin_' . $i;
        ${"super_admin_" . $i} = $row[$column_db];
    }
    for ($i = 1; $i <= 100; $i++) {
        $column_db = 'admin_junior_' . $i;
        ${"admin_junior_" . $i} = $row[$column_db];
    }
    for ($i = 1; $i <= 100; $i++) {
        $column_db = 'coordinador_' . $i;
        ${"coordinador_" . $i} = $row[$column_db];
    }
    for ($i = 1; $i <= 100; $i++) {
        $column_db = 'operador_' . $i;
        ${"operador_" . $i} = $row[$column_db];
    }
    for ($i = 1; $i <= 100; $i++) {
        $column_db = 'recluta_' . $i;
        ${"recluta_" . $i} = $row[$column_db];
    }
}

echo ($super_admin_1);

// Values for the table of roles
$pro_gestor_1 = ['Listado de Nota de Atención', 'Abrir de Nota de Atención'];
$pro_gestor_2 = ['Listado de Nota Pendiente', 'Abrir Nota Pendiente'];
$pro_gestor_3 = ['Listado de Pagos', 'Registro de Pagos', 'Editar/Alterar Pagos Registrados'];
$pro_gestor_4 = ['Listado de Usuarios', 'Crear usuario', 'Editar usuario', 'Contraseña de Usuario', 'Permisos de Usuario', 'Borrar Usuario'];
$pro_gestor_5 = ['Listado de Guests', 'Crear Guests', 'Editar Guests', 'Contraseña de Guests', 'Permisos de Guests', 'Borrar Guests', 'Dash Boards'];

$baby_site_1 = ['Listado Sort_GES', 'Alta Sort_GES', 'Documentación', 'Alterar Documentación', 'Start Programa', 'Alta Seguro'];
$baby_site_2 = ['Listado Sort_IP', 'Editar Sort_IP', 'Documentación', 'Alterar/Borrar Documentación', 'Start Crio Embrio', 'Actualizar Seguimiento'];
$baby_site_3 = ['Programas', 'Crioembrio', 'Asignar/Editar Donante', 'Editar Material Genético', 'Seleccionar Material Genético', 'Asignar/Editar Gestante', 'Iniciales', 'Perfil Psicológico', 'Agregar Sesión Psicológica', 'Alterar datos Sesión Psicológica', 'Socio Económico', 'Agregar Visita ESE', 'Alterar Datos ESE', 'Alta Citas', 'Agregar Tratamientos', 'Enviar a Pizarrón', 'Pizarrón', 'Agregar ACO', 'Detener ACO', 'Comenzar Preparación', 'Detener Preparación', 'Enviar a Transfer', 'Registrar Beta', 'Registrar Saco Gestacional', 'Registrar Latido', 'Confirmar GESTA', 'Comenzar SDG GESTA', 'Agenda de Seguro'];
$baby_site_4 = ['Listado Egg Donor'];
$baby_site_5 = ['Dash Boards'];

$baby_cloud_1 = ['Inicio'];

$alta_1 = ['Inicio'];

$sections_1 = array(
    $pro_gestor_1,
    $pro_gestor_2,
    $pro_gestor_3,
    $pro_gestor_4,
    $pro_gestor_5
);

$sections_2 = array(
    $baby_site_1,
    $baby_site_2,
    $baby_site_3,
    $baby_site_4,
    $baby_site_5
);

$sections_3 = array(
    $baby_cloud_1
);

$sections_4 = array(
    $alta_1
);

?>

<main class="dashboard">
    <header class="d-flex justify-content-end align-items-center header-bills">
        <div class="icons">
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                </svg>
            </a>
            <a href="#">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
                </svg>
            </a>
        </div>
        <div class="user">
            <div class="name"><?php echo $name_user; ?></div>
            <div class="last-name"><?php echo $last_name_user; ?></div>
        </div>
        <div class="profile-pic">
            <img style="cursor:pointer;" onclick="toggleDropdown()" src="../../../../build/img/testImg/profilepic.webp" alt="Profile Picture">
            <div id="myDropdown-profile" class="dropdown-content-profile">
                <a href="../../../../logout.php">Cerrar sesión
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                    </svg>
                </a>
            </div>
        </div>
    </header>
    <div class="sidebar">
        <div class="lateral">
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../../build/img/icons/babySite-admin.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">PRO GESTOR</div>
                    <?php if ($access_20 >= 1){ ?>
<a class="dropdown-item active" href="../reports.php">Generación de reportes y facturas</a>
<?php } ?>
                    <?php if ($access_8 >= 1){ ?>
<a class="dropdown-item" href="../users.php">Listado de Usuarios</a>
<?php } ?>
                    <?php if ($access_14 >= 1) { ?>
<a class="dropdown-item" href="../guests.php">Listado de Guests</a>
<?php } ?>
                    <a class="dropdown-item" href="payments.php">Listado de Pagos</a>
                    <a class="dropdown-item" href="#">Listado de Notas</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../../build/img/icons/babySite-user.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">BABY SITE</div>
                    <a class="dropdown-item" href="#">Listado Sort_GES</a>
                    <a class="dropdown-item" href="#">Listado Sort_IPS</a>
                    <a class="dropdown-item" href="#">Listado Sort_DON</a>
                    <a class="dropdown-item" href="#">Programas</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../../build/img/icons/babySite-recluta.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">RECLUTA</div>
                    <a class="dropdown-item" href="#">Nueva Candidata</a>
                    <a class="dropdown-item" href="#">Nueva Donante</a>
                    <a class="dropdown-item" href="#">Mi Listado</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../../build/img/icons/babySite-upload.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">Baby Cloud</div>
                    <a class="dropdown-item" href="../../baby_cloud_upload/sort_ips.php">Cloud_IPS Upload</a>
                    <a class="dropdown-item" href="#">Cloud_GES Upload</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
        </div>
        <div class="lateral-info">
            <div class="logo">
                <a href="../home.php"><img src="../../../../build/img/logos/babySite.webp" alt="Baby Site Logo"></a>
            </div>
            <div class="date">
                <div>
                    <div class="day"><?php echo $dt->format('d'); ?></div>
                    <div class="month"><?php echo $dt->format('M'); ?></div>
                </div>
                <div>
                    <div class="time"><?php echo $dt->format('H:i:s'); ?></div>
                    <div class="day-of-week"><?php echo $dt->format('l'); ?></div>
                </div>
            </div>
            <div class="clock">
                <div class="tick tick-0"></div>
                <div class="tick tick-15"></div>
                <div class="tick tick-30"></div>
                <div class="tick tick-45"></div>
                <div class="hand hour" id="hour-hand"></div>
                <div class="hand minute" id="minute-hand"></div>
                <div class="hand second" id="second-hand"></div>
                <div class="center-dot"></div>
            </div>
            <div class="calendar">
                <div class="header">
                    <button id="prev">&#8592;</button>
                    <h2 id="monthYear"></h2>
                    <button id="next">&#8594;</button>
                </div>
                <div class="weekdays">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div id="days" class="days"></div>
            </div>
        </div>
    </div>
    <div class="content" id="content">
        <div class="header">
            <div class="message">
                Reporte Médico
            </div>
        </div>
        <div class="super-admin-body bills users-body">
            <form class="pink-form" action="medicalReport.php" method="POST" enctype="multipart/form-data">
                <div class="form-info">
                    <div class="bills-info bills-info-3">
                        <div>
                            <label for="date" class="form-label">Fecha *</label>
                            <input class="form-control" id="date" type="date" name="date" required />
                        </div>
                        <div>
                            <label for="doctor" class="form-label">Médico tratante *</label>
                            <input class="form-control" id="doctor" type="text" name="doctor" required />
                        </div>
                        <div>
                            <label for="name" class="form-label">Nombre de paciente *</label>
                            <input class="form-control" id="name" type="text" name="name" required />
                        </div>
                        <div>
                            <label for="age" class="form-label">Edad *</label>
                            <input class="form-control" id="age" type="number" name="age" required />
                        </div>
                        <div>
                            <label for="date-menst" class="form-label">Fecha de última menstruación *</label>
                            <input class="form-control" id="date-menst" type="date" name="date-menst" required />
                        </div>
                        <div>
                            <label for="gest-age" class="form-label">Edad gestacional *</label>
                            <input class="form-control" id="gest-age" type="text" name="gest-age" required />
                        </div>
                    </div>
                    <div class="title">Parámetros biofísicos</div>
                    <div class="bills-info-2 bills-info">
                        <div>
                            <label for="diameter" class="form-label">Diámetro biparietal (DBP) - Valor (cm) *</label>
                            <input class="form-control" id="diameter" type="number" step="0.01" name="diameter" required />
                        </div>
                        <div>
                            <label for="diameter-age" class="form-label">Diámetro biparietal (DBP) - Edad gestacional (semanas) *</label>
                            <input class="form-control" id="diameter-age" type="number" step="0.01" name="diameter-age" required />
                        </div>
                        <div>
                            <label for="circumference" class="form-label">Circunferencia cefálica (CC) - Valor (cm) *</label>
                            <input class="form-control" id="circumference" type="number" step="0.01" name="circumference" required />
                        </div>
                        <div>
                            <label for="circumference-age" class="form-label">Circunferencia cefálica (CC) - Edad gestacional (semanas) *</label>
                            <input class="form-control" id="circumference-age" type="number" step="0.01" name="circumference-age" required />
                        </div>
                        <div>
                            <label for="circumference-abdm" class="form-label">Circunferencia abdominal (CA) - Valor (cm) *</label>
                            <input class="form-control" id="circumference-abdm" type="number" step="0.01" name="circumference-abdm" required />
                        </div>
                        <div>
                            <label for="circumference-abdm-age" class="form-label">Circunferencia abdominal (CA) - Edad gestacional (semanas) *</label>
                            <input class="form-control" id="circumference-abdm-age" type="number" step="0.01" name="circumference-abdm-age" required />
                        </div>
                        <div>
                            <label for="length" class="form-label">Longitud femoral (LF) - Valor (cm) *</label>
                            <input class="form-control" id="length" type="number" step="0.01" name="length" required />
                        </div>
                        <div>
                            <label for="length-age" class="form-label">Longitud femoral (LF) - Edad gestacional (semanas) *</label>
                            <input class="form-control" id="length-age" type="number" step="0.01" name="length-age" required />
                        </div>
                        <div>
                            <label for="fetometry" class="form-label">Fetometría promedio *</label>
                            <input class="form-control" id="fetometry" type="text" name="fetometry" required />
                        </div>
                        <div>
                            <label for="fetal-weight" class="form-label">Peso fetal estimado (PFE) *</label>
                            <input class="form-control" id="fetal-weight" type="text" name="fetal-weight" required />
                        </div>
                        <div>
                            <label for="perc-weight" class="form-label">Percentil de peso *</label>
                            <input class="form-control" id="perc-weight" type="text" name="perc-weight" required />
                        </div>
                        <div>
                            <label for="cardiac-frec" class="form-label">Frecuencia cardiaca fetal *</label>
                            <input class="form-control" id="cardiac-frec" type="text" name="cardiac-frec" required />
                        </div>
                    </div>
                    <div class="title">Comentarios y conclusiones *</div>
                    <div class="bills-info bills-info-1">
                        <div>
                            <textarea class="form-control" id="comments" name="comments" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="title">Impresión diagnóstica *</div>
                    <div class="bills-info bills-info-1">
                        <div>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="title">Imágenes</div>
                    <div class="bills-info bills-info-img">
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 1 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile()" class="form-control img-1-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-1" />
                            <img class="img-1-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 2 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile2()" class="form-control img-2-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-2" />
                            <img class="img-2-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 3 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile3()" class="form-control img-3-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-3" />
                            <img class="img-3-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 4 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile4()" class="form-control img-4-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-4" />
                            <img class="img-4-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 5 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile5()" class="form-control img-5-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-5" />
                            <img class="img-5-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 6 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile6()" class="form-control img-6-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-6" />
                            <img class="img-6-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 7 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile7()" class="form-control img-7-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-7" />
                            <img class="img-7-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                        <div>
                            <label class="label-form" for="validationCustomUsername">Imagen 8 (Tamaño recomendado: 470px X 330px)</label>
                            <input type="file" onchange="previewFile8()" class="form-control img-8-input" id="validationCustomUsername" aria-describedby="inputGroupPrepend" name="image-8" />
                            <img class="img-8-pre" alt="Image preview...">
                            <div class="invalid-feedback">
                                <div>Seleccione una imagen</div>
                            </div>
                        </div>
                    </div>
                    <div class="bills-info required-fields">
                        <p>*Required fields</p>
                    </div>
                </div>
                <div class="form-btn d-flex justify-content-center">
                    <button class="btn btn-pink btn-send" type="submit">
                        <div>Generar PDF</div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Boostrap JS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../../../../build/js/bundle.min.js"></script>
<script>
    // Clock functionality
    function updateClock() {
        const now = new Date();
        const second = now.getSeconds();
        const minute = now.getMinutes();
        const hour = now.getHours();

        const secondDeg = second * 6;
        const minuteDeg = minute * 6 + second * 0.1;
        const hourDeg = (hour % 12) * 30 + minute * 0.5;

        document.getElementById("second-hand").style.transform = `rotate(${secondDeg}deg)`;
        document.getElementById("minute-hand").style.transform = `rotate(${minuteDeg}deg)`;
        document.getElementById("hour-hand").style.transform = `rotate(${hourDeg}deg)`;
    }

    setInterval(updateClock, 1000);
    updateClock(); // initialize

    // Calendar functionality
    const daysContainer = document.getElementById('days');
    const monthYear = document.getElementById('monthYear');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');

    let currentDate = new Date();

    function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();

        daysContainer.innerHTML = '';
        monthYear.innerText = `${date.toLocaleString('en-US', { month: 'long' })} ${year}`;

        // Fill initial empty cells
        for (let i = 0; i < firstDay; i++) {
            daysContainer.innerHTML += '<div></div>';
        }

        // Fill actual days
        for (let i = 1; i <= lastDate; i++) {
            const isToday = i === new Date().getDate() &&
                month === new Date().getMonth() &&
                year === new Date().getFullYear();
            daysContainer.innerHTML += `<div class="${isToday ? 'today' : ''}">${i}</div>`;
        }
    }

    prevBtn.onclick = () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    };

    nextBtn.onclick = () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    };

    renderCalendar(currentDate);
</script>
<!-- Favicon -->
<script src="https://kit.fontawesome.com/b8332e4c7c.js" crossorigin="anonymous"></script>
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Are you sure?');
    }
</script>
<!-- Custom JS -->
<script src="../../../../build/js/paginationFilter.min.js"></script>
<!-- Pagination -->
<script>
    let options = {
        numberPerPage: 30, //Cantidad de datos por pagina
        goBar: true, //Barra donde puedes digitar el numero de la pagina al que quiere ir
        pageCounter: true, //Contador de paginas, en cual estas, de cuantas paginas
    };
    let filterOptions = {
        el: "#searchBox", //Caja de texto para filtrar, puede ser una clase o un ID
    };
    paginate.init(".myTable", options, filterOptions);

    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
<!-- Communication with DB -->
<script>
    // Access functionality logic
    function toggleAccess(row, column, state) {
        functionName = "toggleAccess";
        id = 1
        switch (column) {
            case 1:
                columnName = "super_admin_";
                break;
            case 2:
                columnName = "admin_junior_";
                break;
            case 3:
                columnName = "coordinador_";
                break;
            case 4:
                columnName = "operador_";
                break;
            case 5:
                columnName = "recluta_";
                break;
            default:
        }
        column = columnName + row;
        newValue = state;
        fetchContent(functionName, id, newValue, column)
        location.reload();
    }

    // Selection of rows to delete

    if (!Array.isArray(selectedRows)) {
        var selectedRows = [];
        const deleteButton = document.getElementById('delete_selected');
        deleteButton.disabled = true;
    }

    function selectRows(tdElement, id) {
        const checkbox_id = "checkbox_" + id;
        const checkbox = document.getElementById(checkbox_id);
        if (checkbox.checked) {
            selectedRows.push(id);
        } else {
            selectedRows = selectedRows.filter(row => row !== id);
        }
        if (selectedRows.length > 0) {
            const deleteButton = document.getElementById('delete_selected');
            deleteButton.disabled = false;
        } else {
            const deleteButton = document.getElementById('delete_selected');
            deleteButton.disabled = true;
        }
    }

    function deleteSelected() {
        confirm('¿Deseas eliminar a los usuarios seleccionados?')
        functionName = 'deleteSelected';
        fetchContent(functionName, selectedRows);
        location.reload();
    }

    function newUser() {
        fetchContent('insert');
        location.reload();
    }

    function updateContent(tdElement, id, column) {
        const newValue = tdElement.innerText;
        functionName = 'update';
        fetchContent(functionName, id, newValue, column);
    }

    function updateContent2(tdElement, id, column) {
        const selectElement = document.getElementById('select_' + id);
        const newValue = selectElement.value;
        functionName = 'update';
        fetchContent(functionName, id, newValue, column);
    }

    function toggle(newValue, id, column) {
        functionName = 'update';
        fetchContent(functionName, id, newValue, column);
        location.reload();
    };

    function fetchContent(functionName, id = null, newValue = null, column = null) {
        fetch('usersBack.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    function: functionName,
                    id: id,
                    newValue: newValue,
                    column: column
                })
            })
            .then(res => res.text()) // expect plain text for echo
            .then(data => {
                console.log('Server responded with:', data);
            })
            .catch(error => console.error('Error:', error));
    }

    // Dropdown menu profile

    function toggleDropdown() {
        document.getElementById("myDropdown-profile").classList.toggle("profile-show");
        document.getElementById("content").classList.toggle("content-show");
    }

    // Optional: close dropdown when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('img')) {
            var dropdowns = document.getElementsByClassName("dropdown-content-profile");
            for (let i = 0; i < dropdowns.length; i++) {
                let openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('profile-show')) {
                    openDropdown.classList.remove('profile-show');
                    document.getElementById("content").classList.remove("content-show");
                }
            }
        }
    }
</script>
<script>
    function previewFile() {
        var preview = document.querySelector(".img-1-pre");
        var file = document.querySelector(".img-1-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile2() {
        var preview = document.querySelector(".img-2-pre");
        var file = document.querySelector(".img-2-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile3() {
        var preview = document.querySelector(".img-3-pre");
        var file = document.querySelector(".img-3-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile4() {
        var preview = document.querySelector(".img-4-pre");
        var file = document.querySelector(".img-4-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile5() {
        var preview = document.querySelector(".img-5-pre");
        var file = document.querySelector(".img-5-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile6() {
        var preview = document.querySelector(".img-6-pre");
        var file = document.querySelector(".img-6-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile7() {
        var preview = document.querySelector(".img-7-pre");
        var file = document.querySelector(".img-7-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    function previewFile8() {
        var preview = document.querySelector(".img-8-pre");
        var file = document.querySelector(".img-8-input").files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;

        };

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>
</body>

</html>