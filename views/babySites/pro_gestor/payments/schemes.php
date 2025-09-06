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
    for ($i = 1; $i <= 100; $i++) {
        ${'access_' . $i} = $row['access_' . $i];
    }
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
    // if ($row['profile'] == 'admin_junior') {
    //     $profile[$index] = 'senior';
    // } else {
    $profile[$index] = $row['profile'];
    // }
    $enabled[$index] = $row['enabled'];
    $created_on[$index] = $row['created_on'];
}

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
                    <?php if ($access_20 >= 1) { ?>
                        <a class="dropdown-item" href="reports.php">Generación de reportes y facturas</a>
                    <?php } ?>
                    <?php if ($access_8 >= 1) { ?>
                        <?php if ($access_8 >= 1) { ?>
                            <a class="dropdown-item" href="users.php">Listado de Usuarios</a>
                        <?php } ?>
                    <?php } ?>
                    <?php if ($access_14 >= 1) { ?>
                        <a class="dropdown-item" href="guests.php">Listado de Guests</a>
                    <?php } ?>
                    <a class="dropdown-item active" href="payments.php">Listado de Pagos</a>
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
                    <a class="dropdown-item" href="../baby_cloud_upload/sort_ips.php">Cloud_IPS Upload</a>
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
        <?php if ($access_8 >= 1) { ?>
            <div class="header">
                <div class="message">
                    Listado de Esquemas
                </div>
                <div class="buttons">
                    <?php if ($access_9 >= 1) { ?>
                        <button <?php if ($access_9 == 2) { ?> onclick="newUser()" <?php } ?>>
                            Generar hoja de pago
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M128 128C128 92.7 156.7 64 192 64L341.5 64C358.5 64 374.8 70.7 386.8 82.7L493.3 189.3C505.3 201.3 512 217.6 512 234.6L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 128zM336 122.5L336 216C336 229.3 346.7 240 360 240L453.5 240L336 122.5zM192 152C192 165.3 202.7 176 216 176L264 176C277.3 176 288 165.3 288 152C288 138.7 277.3 128 264 128L216 128C202.7 128 192 138.7 192 152zM192 248C192 261.3 202.7 272 216 272L264 272C277.3 272 288 261.3 288 248C288 234.7 277.3 224 264 224L216 224C202.7 224 192 234.7 192 248zM304 324L304 328C275.2 328.3 252 351.7 252 380.5C252 406.2 270.5 428.1 295.9 432.3L337.6 439.3C343.6 440.3 348 445.5 348 451.6C348 458.5 342.4 464.1 335.5 464.1L280 464C269 464 260 473 260 484C260 495 269 504 280 504L304 504L304 508C304 519 313 528 324 528C335 528 344 519 344 508L344 503.3C369 499.2 388 477.6 388 451.5C388 425.8 369.5 403.9 344.1 399.7L302.4 392.7C296.4 391.7 292 386.5 292 380.4C292 373.5 297.6 367.9 304.5 367.9L352 367.9C363 367.9 372 358.9 372 347.9C372 336.9 363 327.9 352 327.9L344 327.9L344 323.9C344 312.9 335 303.9 324 303.9C313 303.9 304 312.9 304 323.9z" />
                            </svg>
                        </button>
                    <?php } ?>
                    <?php if ($access_12 > 0) { ?>
                        <button>
                            <a href=<?php if ($access_12 > 1) {
                                        echo "roles.php";
                                    } else {
                                        echo "#";
                                    } ?>>Registrar pagos</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                <path d="M128 128C92.7 128 64 156.7 64 192L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 192C576 156.7 547.3 128 512 128L128 128zM360 352L488 352C501.3 352 512 362.7 512 376C512 389.3 501.3 400 488 400L360 400C346.7 400 336 389.3 336 376C336 362.7 346.7 352 360 352zM336 264C336 250.7 346.7 240 360 240L488 240C501.3 240 512 250.7 512 264C512 277.3 501.3 288 488 288L360 288C346.7 288 336 277.3 336 264zM212 208C223 208 232 217 232 228L232 232L240 232C251 232 260 241 260 252C260 263 251 272 240 272L192.5 272C185.6 272 180 277.6 180 284.5C180 290.6 184.4 295.8 190.4 296.8L232.1 303.8C257.4 308 276 329.9 276 355.6C276 381.7 257 403.3 232 407.4L232 412.1C232 423.1 223 432.1 212 432.1C201 432.1 192 423.1 192 412.1L192 408.1L168 408.1C157 408.1 148 399.1 148 388.1C148 377.1 157 368.1 168 368.1L223.5 368.1C230.4 368.1 236 362.5 236 355.6C236 349.5 231.6 344.3 225.6 343.3L183.9 336.3C158.5 332 140 310.1 140 284.5C140 255.7 163.2 232.3 192 232L192 228C192 217 201 208 212 208z" />
                            </svg>
                        </button>
                    <?php } ?>
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
            <div class="scheme-body">
                <div class="content table-responsive table-scroll table-full-width table-container">
                    <div class="panel">
                        <div class="body">
                            <div class="input-group">
                                <?php if ($access_13 > 0) { ?>
                                    <button id="delete_selected" <?php if ($access_13 > 1) {
                                                                        echo "onclick='deleteSelected()'";
                                                                    } ?>>Borrar selección </button>
                                <?php } ?>
                                <div class="searchBox">
                                    <label for="searchBox"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                                        </svg></label>
                                    <input type="search" id="searchBox" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover myTable" id="myTable">
                        <thead aria-expanded="true" style="cursor: pointer;">
                            <tr class="thead">
                                <th></th>
                                <th>GESTA/GESCA
                                    <img onclick="sortTable(0)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                                </th>
                                <th>Status Gral
                                    <img onclick="sortTable(1)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                                </th>
                                <th>SEG SDG
                                    <img onclick="sortTable(2)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                                </th>
                                <th>Último Pgto
                                    <img onclick="sortTable(3)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                                </th>
                                <th>Fecha
                                    <img onclick="sortTable(4)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                                </th>
                                <th>Prox. Pgto</th>
                                <th>Concept</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <colgroup class="table-colgroup">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                                <col>
                            </colgroup>
                            <?php for ($i = 1; $i <= $index; $i++) { ?>
                                <?php if ($id[$i] != $id_user) { ?>
                                    <tr id="<?php echo $id[$i]; ?>">
                                        <td class="td-center"><input id="checkbox_<?php echo $id[$i]; ?>" type="checkbox" onclick="selectRows(this, <?php echo $id[$i] ?>)"> </td>
                                        <td contenteditable=<?php if ($access_10 > 1) {
                                                                echo "true";
                                                            } else {
                                                                echo "false";
                                                            } ?> onkeyup='updateContent(this,<?php echo $id[$i] ?>,"username")'><?php echo $user[$i] ?></td>
                                        <td contenteditable=<?php if ($access_10 > 1) {
                                                                echo "true";
                                                            } else {
                                                                echo "false";
                                                            } ?> onkeyup='updateContent(this,<?php echo $id[$i] ?>,"mail")'><?php echo $mail[$i] ?></td>
                                        <td contenteditable=<?php if ($access_11 > 1) {
                                                                echo "true";
                                                            } else {
                                                                echo "false";
                                                            } ?> onkeyup='updateContent(this,<?php echo $id[$i] ?>,"password")'><?php echo $pass[$i] ?></td>
                                        <td>
                                            <select onchange='updateContent2(this,<?php echo $id[$i] ?>,"profile")' id="<?php echo 'select_' . $id[$i]; ?>" <?php if (!($access_10 > 1)) {
                                                                                                                                                                echo "disabled";
                                                                                                                                                            } ?>>
                                                <?php if ($profile[$i] == 'super_admin') { ?>
                                                    <option value="super_admin" selected>super-admin</option>
                                                    <option value="admin_junior">senior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'admin_junior') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior" selected>senior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'coordinador') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">senior</option>
                                                    <option value="coordinador" selected>coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'operador') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">senior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador" selected>operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">senior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta" selected>recluta</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <?php echo $created_on[$i]; ?>
                                        </td>
                                        <td class="td-center td-icon">
                                            <?php if ($access_12 > 0) { ?>
                                                <?php if ($enabled[$i] == 'true') { ?>
                                                    <button onclick='toggle("false",<?php echo $id[$i] ?>,"enabled")' <?php if (!($access_12 > 1)) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>
                                                        <i class='fa-solid fa-toggle-on false'></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button onclick='toggle("true",<?php echo $id[$i] ?>,"enabled")' <?php if (!($access_12 > 1)) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>
                                                        <i class='fa-solid fa-toggle-off false'></i>
                                                    </button>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <p>-</p>
                                            <?php } ?>
                                        </td>
                                        <td class="td-center">
                                            <?php if ($access_12 > 0) { ?>
                                                <button class="td-delete" onclick="deteleOne(<?php echo $id[$i] ?>)" <?php if ($access_13 < 2) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                                    </svg>
                                                </button>
                                            <?php } else { ?>
                                                <p>
                                                    -
                                                </p>
                                            <?php } ?>
                                        </td>
                                        <td class="td-center">
                                            <?php if ($access_13 > 0) { ?>
                                                <button class="td-delete" onclick="deteleOne(<?php echo $id[$i] ?>)" <?php if ($access_13 < 2) {
                                                                                                                            echo "disabled";
                                                                                                                        } ?>>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 640 640"><!--!Font Awesome Free v7.0.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                                                        <path d="M128 128C128 92.7 156.7 64 192 64L341.5 64C358.5 64 374.8 70.7 386.8 82.7L493.3 189.3C505.3 201.3 512 217.6 512 234.6L512 512C512 547.3 483.3 576 448 576L192 576C156.7 576 128 547.3 128 512L128 128zM336 122.5L336 216C336 229.3 346.7 240 360 240L453.5 240L336 122.5zM192 152C192 165.3 202.7 176 216 176L264 176C277.3 176 288 165.3 288 152C288 138.7 277.3 128 264 128L216 128C202.7 128 192 138.7 192 152zM192 248C192 261.3 202.7 272 216 272L264 272C277.3 272 288 261.3 288 248C288 234.7 277.3 224 264 224L216 224C202.7 224 192 234.7 192 248zM304 324L304 328C275.2 328.3 252 351.7 252 380.5C252 406.2 270.5 428.1 295.9 432.3L337.6 439.3C343.6 440.3 348 445.5 348 451.6C348 458.5 342.4 464.1 335.5 464.1L280 464C269 464 260 473 260 484C260 495 269 504 280 504L304 504L304 508C304 519 313 528 324 528C335 528 344 519 344 508L344 503.3C369 499.2 388 477.6 388 451.5C388 425.8 369.5 403.9 344.1 399.7L302.4 392.7C296.4 391.7 292 386.5 292 380.4C292 373.5 297.6 367.9 304.5 367.9L352 367.9C363 367.9 372 358.9 372 347.9C372 336.9 363 327.9 352 327.9L344 327.9L344 323.9C344 312.9 335 303.9 324 303.9C313 303.9 304 312.9 304 323.9z" />
                                                    </svg>
                                                </button>
                                            <?php } else { ?>
                                                <p>-</p>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                    <tr id="<?php echo $id[$i]; ?>" class="disabled-row">
                                        <td class="td-center"><input id="checkbox_<?php echo $id[$i]; ?>" type="checkbox" onclick="selectRows(this, <?php echo $id[$i] ?>)" disabled> </td>
                                        <td contenteditable='false' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"username")'><?php echo $user[$i] ?></td>
                                        <td contenteditable='false' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"mail")'><?php echo $mail[$i] ?></td>
                                        <td contenteditable='false' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"password")'><?php echo $pass[$i] ?></td>
                                        <td>
                                            <select onchange='updateContent2(this,<?php echo $id[$i] ?>,"profile")' id="<?php echo 'select_' . $id[$i]; ?>" disabled>
                                                <?php if ($profile[$i] == 'super_admin') { ?>
                                                    <option value="super_admin" selected>super-admin</option>
                                                    <option value="admin_junior">admin-junior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'admin_junior') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior" selected>admin-junior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'coordinador') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">admin-junior</option>
                                                    <option value="coordinador" selected>coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else if ($profile[$i] == 'operador') { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">admin-junior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador" selected>operador</option>
                                                    <option value="recluta">recluta</option>
                                                <?php } else { ?>
                                                    <option value="super_admin">super-admin</option>
                                                    <option value="admin_junior">admin-junior</option>
                                                    <option value="coordinador">coordinador</option>
                                                    <option value="operador">operador</option>
                                                    <option value="recluta" selected>recluta</option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <?php echo $created_on[$i]; ?>
                                        </td>
                                        <td class="td-center td-icon">
                                            <?php if ($enabled[$i] == 'true') { ?>
                                                <button onclick='toggle("false",<?php echo $id[$i] ?>,"enabled")' disabled>
                                                    <i class='fa-solid fa-toggle-on false'></i>
                                                </button>
                                            <?php } else { ?>
                                                <button onclick='toggle("true",<?php echo $id[$i] ?>,"enabled")' disabled>
                                                    <i class='fa-solid fa-toggle-off false'></i>
                                                </button>
                                            <?php } ?>
                                        </td>
                                        <td class="td-center">
                                            <a class="td-delete td-center" href="<?php echo "roles.php?id=" . $id[$i]; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="td-center">
                                            <button class="td-delete" onclick="deteleOne(<?php echo $id[$i] ?>)">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
        numberPerPage: 10000000000000, //Cantidad de datos por pagina
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
            console.log("ok");
        } else {
            const deleteButton = document.getElementById('delete_selected');
            deleteButton.disabled = true;
            console.log("not ok");
        }
    }

    function deteleOne(id) {
        if (confirm('¿Desear eliminar al usuario?')) {
            functionName = 'delete';
            fetchContent(functionName, id);
            const row = document.getElementById(id);
            if (row) row.remove();
        }
    }

    function deleteSelected() {
        if (confirm('¿Deseas eliminar a los usuarios seleccionados?')) {
            functionName = 'deleteSelected';
            fetchContent(functionName, selectedRows);
            const selectedRowsValues = Object.values(selectedRows);
            for (let i = 0; i < selectedRowsValues.length; i++) {
                const row = document.getElementById(selectedRowsValues[i]);
                console.log("Eliminando fila con ID:", selectedRowsValues[i]);
                console.log(i);
                if (row) row.remove();
            }
        }
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
                    column: column,
                    page: 'users'
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