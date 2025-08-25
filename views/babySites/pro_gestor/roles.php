<?php
include '../../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../../build/css/app.css" />
<link href="../../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../../includes/templates/header_end.php';
include '../../../includes/app.php';
include '../../../includes/templates/sessionStart.php';
include '../../../includes/templates/validateAccessInternal.php';

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

if (isset($_GET['id'])) {
    $ip_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=${ip_id}";
    $result = mysqli_query($conn, $sql);
    $index = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $profile = $row['profile'];
        $user = $row['username'];
        for ($i = 1; $i <= 100; $i++) {
            ${$profile . '_' . $i} = $row['access_' . $i];
        }
    }
} else {
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
}

// Values for the table of roles
$pro_gestor_1 = ['Listado de Nota de Atención', 'Abrir de Nota de Atención'];
$pro_gestor_2 = ['Listado de Nota Pendiente', 'Abrir Nota Pendiente'];
$pro_gestor_3 = ['Listado de Pagos', 'Registro de Pagos', 'Editar/Alterar Pagos Registrados'];
$pro_gestor_4 = ['Listado de Usuarios', 'Crear usuario', 'Editar usuario', 'Contraseña de Usuario', 'Permisos de Usuario', 'Borrar Usuario'];
$pro_gestor_5 = ['Listado de Guests', 'Crear Guests', 'Editar Guests', 'Contraseña de Guests', 'Permisos de Guests', 'Borrar Guests'];
$pro_gestor_6 = ['Generación de reportes y facturas', 'Generar reporte médico', 'Generar Itinerario', 'Generar factura (Travel Medical Care)', 'Generar factura (Nexa Travel)', 'Generar factura (Babymedic)', 'Dash Boards'];

$baby_site_1 = ['Listado Sort_GES', 'Alta Sort_GES', 'Documentación', 'Alterar Documentación', 'Start Programa', 'Alta Seguro'];
$baby_site_2 = ['Listado Sort_IP', 'Alta Sort_IP', 'Editar Sort_IP', 'Documentación', 'Alterar/Borrar Documentación', 'Start Crio Embrio', 'Actualizar Seguimiento'];
$baby_site_3 = ['Programas', 'Crioembrio', 'Asignar/Editar Donante', 'Editar Material Genético', 'Seleccionar Material Genético', 'Asignar/Editar Gestante', 'Iniciales', 'Perfil Psicológico', 'Agregar Sesión Psicológica', 'Alterar datos Sesión Psicológica', 'Socio Económico', 'Agregar Visita ESE', 'Alterar Datos ESE', 'Alta Citas', 'Agregar Tratamientos', 'Enviar a Pizarrón', 'Pizarrón', 'Agregar ACO', 'Detener ACO', 'Comenzar Preparación', 'Detener Preparación', 'Enviar a Transfer', 'Registrar Beta', 'Registrar Saco Gestacional', 'Registrar Latido', 'Confirmar GESTA', 'Comenzar SDG GESTA', 'Agenda de Seguro'];
$baby_site_4 = ['Listado Egg Donor'];
$baby_site_5 = ['Dash Boards'];

$recluta_s_1 = ['Inicio'];

$baby_cloud_1 = ['Agregar etapa', 'Modificar estado', 'Modificar underway', 'Modificar info 1', 'Modificar info 2', 'Subir archivo 1', 'Subir archivo 2', 'Subir archivo 3', 'Habilitar 1', 'Habilitar 2', 'Habilitar 3', 'Habilitar vista de la etapa'];
// $baby_cloud_1 = ['Inicio'];

$sections_1 = array(
    $pro_gestor_1,
    $pro_gestor_2,
    $pro_gestor_3,
    $pro_gestor_4,
    $pro_gestor_5,
    $pro_gestor_6
);

$sections_2 = array(
    $baby_site_1,
    $baby_site_2,
    $baby_site_3,
    $baby_site_4,
    $baby_site_5
);

$sections_3 = array(
    $recluta_s_1
);

$sections_4 = array(
    $baby_cloud_1
);

?>

<main class="dashboard">
    <header class="d-flex justify-content-end align-items-center">
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
            <img style="cursor:pointer;" onclick="toggleDropdown()" src="../../../build/img/testImg/profilepic.webp" alt="Profile Picture">
            <div id="myDropdown-profile" class="dropdown-content-profile">
                <a href="../../../logout.php">Cerrar sesión
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
                <img class="icon-img" src="../../../build/img/icons/babySite-admin.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">PRO GESTOR</div>
                    <?php if ($access_20 >= 1){ ?>
<a class="dropdown-item" href="reports.php">Generación de reportes y facturas</a>
<?php } ?>
                    <?php if ($access_8 >= 1){ ?>
<?php if ($access_8 >= 1){ ?>
<a class="dropdown-item" href="users.php">Listado de Usuarios</a>
<?php } ?>
<?php } ?>
                    <?php if ($access_14 >= 1) { ?>
<a class="dropdown-item" href="guests.php">Listado de Guests</a>
<?php } ?>
                    <a class="dropdown-item" href="#">Listado de Pagos</a>
                    <a class="dropdown-item" href="#">Listado de Notas</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../build/img/icons/babySite-user.webp" alt="icon">
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
                <img class="icon-img" src="../../../build/img/icons/babySite-recluta.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">RECLUTA</div>
                    <a class="dropdown-item" href="#">Nueva Candidata</a>
                    <a class="dropdown-item" href="#">Nueva Donante</a>
                    <a class="dropdown-item" href="#">Mi Listado</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../../build/img/icons/babySite-upload.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">Baby Cloud</div>
                    <a class="dropdown-item" href="../baby_cloud_upload/sort_ips.php">Cloud_IPS Upload</a>
                    <a class="dropdown-item" href="#">Cloud_GES Upload</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
        </div>
        <div class="lateral-info">
            <div class="logo">
                <a href="../home.php"><img src="../../../build/img/logos/babySite.webp" alt="Baby Site Logo"></a>
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
    <?php if (isset($_GET['id'])) { ?>
        <div class="content" id="content">
            <div class="header">
                <div class="message">
                    Permisos y roles para el usuario <?php echo $user; ?> con el perfil
                    <?php
                    if ($profile == 'super_admin') {
                        echo 'Super admin';
                    } else if ($profile == 'admin_junior') {
                        echo 'Senior';
                    } else if ($profile == 'coordinador') {
                        echo 'Coordinador';
                    } else if ($profile == 'operador') {
                        echo 'Operador';
                    } else if ($profile == 'recluta') {
                        echo 'Recluta';
                    }
                    ?>
                </div>
                <div class="buttons">
                    <button>
                        <a href="users.php">Regresar al listado de usuarios</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </button>
                </div>
                <div class="info">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="roles-body">
                <div class="content table-responsive table-scroll table-full-width table-container">
                    <table class="table table-hover myTable" id="myTable">
                        <thead data-bs-toggle="collapse" data-bs-target="#section1" style="cursor: pointer;">
                            <tr class="thead">
                                <th>PRO GESTOR</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <?php $row_component = 0; ?>
                        <tbody>
                            <colgroup class="table-colgroup">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                            </colgroup>
                            <?php foreach ($sections_1 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section1">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <td colspan="4"></td>
                                        <?php if ($profile == 'super_admin') { ?>
                                            <?php $cell_component = ${"super_admin_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'admin_junior') { ?>
                                            <?php $cell_component = ${"admin_junior_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'coordinador') { ?>
                                            <?php $cell_component = ${"coordinador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'operador') { ?>
                                            <?php $cell_component = ${"operador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'recluta') { ?>
                                            <?php $cell_component = ${"recluta_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section2" style="cursor: pointer;">
                            <tr class="thead">
                                <th>BABY SITE</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_2 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section2">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <td colspan="4"></td>
                                        <?php if ($profile == 'super_admin') { ?>
                                            <?php $column_component = 1 ?>
                                            <?php $cell_component = ${"super_admin_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($profile == 'admin_junior') { ?>
                                            <?php $column_component++ ?>
                                            <?php $cell_component = ${"admin_junior_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($profile == 'coordinador') { ?>
                                            <?php $column_component++ ?>
                                            <?php $cell_component = ${"coordinador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($profile == 'operador') { ?>
                                            <?php $column_component++ ?>
                                            <?php $cell_component = ${"operador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if ($profile == 'recluta') { ?>
                                            <?php $column_component++ ?>
                                            <?php $cell_component = ${"recluta_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                <?php } ?>
                                                </td>
                                            <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section3" style="cursor: pointer;">
                            <tr class="thead">
                                <th>RECLUTA</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_3 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section3">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <td colspan="4"></td>
                                        <?php if ($profile == 'super_admin') { ?>
                                            <?php $cell_component = ${"super_admin_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'admin_junior') { ?>
                                            <?php $cell_component = ${"admin_junior_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'coordinador') { ?>
                                            <?php $cell_component = ${"coordinador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'operador') { ?>
                                            <?php $cell_component = ${"operador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'recluta') { ?>
                                            <?php $cell_component = ${"recluta_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section4" style="cursor: pointer;">
                            <tr class="thead">
                                <th>Baby Cloud</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_4 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section4">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <td colspan="4"></td>
                                        <?php if ($profile == 'super_admin') { ?>
                                            <?php $cell_component = ${"super_admin_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'admin_junior') { ?>
                                            <?php $cell_component = ${"admin_junior_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'coordinador') { ?>
                                            <?php $cell_component = ${"coordinador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'operador') { ?>
                                            <?php $cell_component = ${"operador_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php if ($profile == 'recluta') { ?>
                                            <?php $cell_component = ${"recluta_" . $row_component};
                                            if ($cell_component == 0) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye-slash'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 1) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } else if ($cell_component == 2) { ?>
                                                <td class="td-icon">
                                                    <div class="buttons-center">
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0, <?php echo $_GET["id"] ?>)'>
                                                            <i class='fa-solid fa-eye'></i>
                                                        </button>
                                                        <button onclick='toggleAccess2(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1, <?php echo $_GET["id"] ?>)'>
                                                            <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                        </button>
                                                    </div>
                                                </td>
                                            <?php } ?>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="content" id="content">
            <div class="header">
                <div class="message">
                    Admin permisos y roles
                </div>
                <div class="buttons">
                    <button>
                        <a href="users.php">Regresar al listado de usuarios</a>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5" />
                        </svg>
                    </button>
                </div>
                <div class="info">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="roles-body">
                <div class="content table-responsive table-scroll table-full-width table-container">
                    <table class="table table-hover myTable" id="myTable">
                        <thead class="header-sticky">
                            <tr class="thead-roles">
                                <th></th>
                                <th>Super admin</th>
                                <th>Senior</th>
                                <th>Coordina</th>
                                <th>Operador</th>
                                <th>Recluta</th>
                            </tr>
                        </thead>
                        <thead data-bs-toggle="collapse" data-bs-target="#section1" style="cursor: pointer;">
                            <tr class="thead">
                                <th>PRO GESTOR</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <?php $row_component = 0; ?>
                        <tbody>
                            <colgroup class="table-colgroup">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                            </colgroup>
                            <?php foreach ($sections_1 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section1">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <?php $cell_component = ${"super_admin_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"admin_junior_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"coordinador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"operador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"recluta_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section2" style="cursor: pointer;">
                            <tr class="thead">
                                <th>BABY SITE</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_2 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section2">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <?php $cell_component = ${"super_admin_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"admin_junior_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"coordinador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"operador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"recluta_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section3" style="cursor: pointer;">
                            <tr class="thead">
                                <th>RECLUTA</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_3 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section3">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <?php $cell_component = ${"super_admin_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"admin_junior_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"coordinador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"operador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"recluta_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                        <thead data-bs-toggle="collapse" data-bs-target="#section4" style="cursor: pointer;">
                            <tr class="thead">
                                <th>Baby Cloud</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <div class="d-flex justify-content-end me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                        </svg>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sections_4 as $section_component) { ?>
                                <?php $row_counter = 1; ?>
                                <?php foreach ($section_component as $row) { ?>
                                    <?php $row_component++; ?>
                                    <tr <?php if ($row_counter == 1) {
                                            echo "class='collapse show row-first'";
                                        } else {
                                            echo "class='collapse show'";
                                        } ?> id="section4">
                                        <td class="td-icon">
                                            <?php echo $row; ?>
                                        </td>
                                        <?php $column_component = 1 ?>
                                        <?php $cell_component = ${"super_admin_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"admin_junior_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"coordinador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"operador_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                        <?php $column_component++ ?>
                                        <?php $cell_component = ${"recluta_" . $row_component};
                                        if ($cell_component == 0) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <i class='fa-solid fa-eye-slash'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 1) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 2)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil-slash.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } else if ($cell_component == 2) { ?>
                                            <td class="td-icon">
                                                <div class="buttons-center">
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 0)'>
                                                        <i class='fa-solid fa-eye'></i>
                                                    </button>
                                                    <button onclick='toggleAccess(<?php echo $row_component; ?>, <?php echo $column_component; ?>, 1)'>
                                                        <img style="cursor:pointer;" src="../../../build/img/svgicons/pencil.webp" alt="icon">
                                                    </button>
                                                </div>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                    <?php $row_counter++; ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>
</main>

<!-- Boostrap JS -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="../../../build/js/bundle.min.js"></script>
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
<script src="../../../build/js/paginationFilter.min.js"></script>
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

    function toggleAccess2(row, column, state, id) {
        functionName = "toggleAccess2";
        switch (column) {
            case 1:
                columnName = "access_";
                break;
            case 2:
                columnName = "access_";
                break;
            case 3:
                columnName = "access_";
                break;
            case 4:
                columnName = "access_";
                break;
            case 5:
                columnName = "access_";
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
</body>

</html>