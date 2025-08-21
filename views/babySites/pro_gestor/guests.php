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

$sql = "SELECT * FROM guests";
$result = mysqli_query($conn, $sql);
$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $id[++$index] = $row['id'];
    $user[$index] = $row['username'];
    $mail[$index] = $row['mail'];
    $pass[$index] = $row['password'];
    $row['profile'] == NULL ? $profile[$index] = 'ip' : $profile[$index] = $row['profile'];
    $row['enabled'] == NULL ? $enabled[$index] = 'false' : $enabled[$index] = $row['enabled'];
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
                    <a class="dropdown-item" href="superadmin.php">Super Admin</a>
                    <a class="dropdown-item" href="users.php">Listado de Usuarios</a>
                    <a class="dropdown-item active" href="guests.php">Listado de Guests</a>
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
    <div class="content" id="content">
        <div class="header">
            <div class="message">
                Listado de Guests
            </div>
            <div class="buttons">
                <button onclick="newUser()">
                    Nuevo Guest
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
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
        <div class="users-body">
            <div class="content table-responsive table-scroll table-full-width table-container">
                <div class="panel">
                    <div class="body">
                        <div class="input-group">
                            <button id="delete_selected" onclick="deleteSelected()">Borrar selección </button>
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
                            <th>Usuario
                                <img onclick="sortTable(0)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                            </th>
                            <th>Email
                                <img onclick="sortTable(1)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                            </th>
                            <th>Password
                                <img onclick="sortTable(2)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                            </th>
                            <th>Perfil
                                <img onclick="sortTable(3)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                            </th>
                            <th>Fecha de creación
                                <img onclick="sortTable(4)" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAaElEQVR4nO2TsQrAMAgF31931DF/bSl06BBC1PegQw5c74hE4EDGAQylPN4ZSnmwIz6R0yK+kLcjO/KoRjLyyEYq8lD9rn9yNVZkyogpX2LpPSUiVpXvRKwrX0Vo8lmELv9e+TMH0LgBO+h/i4EUhhsAAAAASUVORK5CYII=" alt="sort">
                            </th>
                            <th>Status</th>
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
                        </colgroup>
                        <?php for ($i = 1; $i <= $index; $i++) { ?>
                            <?php if ($user[$i] != 'AdminBabyCloud') { ?>
                                <tr id="<?php echo $id[$i]; ?>">
                                    <td class="td-center"><input id="checkbox_<?php echo $id[$i]; ?>" type="checkbox" onclick="selectRows(this, <?php echo $id[$i] ?>)"> </td>
                                    <td contenteditable='true' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"username")'><?php echo $user[$i] ?></td>
                                    <td contenteditable='true' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"mail")'><?php echo $mail[$i] ?></td>
                                    <td contenteditable='true' onkeyup='updateContent(this,<?php echo $id[$i] ?>,"password")'><?php echo $pass[$i] ?></td>
                                    <td>
                                        <select onchange='updateContent2(this,<?php echo $id[$i] ?>,"profile")' id="<?php echo 'select_' . $id[$i]; ?>">
                                            <?php if ($profile[$i] == 'ip') { ?>
                                                <option value="ip" selected>IP</option>
                                                <option value="agency">Agency</option>
                                            <?php } else if ($profile[$i] == 'agency') { ?>
                                                <option value="ip">IP</option>
                                                <option value="agency" selected>Agency</option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td>
                                        <?php echo $created_on[$i]; ?>
                                    </td>
                                    <td class="td-center td-icon">
                                        <?php if ($enabled[$i] == 'true') { ?>
                                            <button onclick='toggle("false",<?php echo $id[$i] ?>,"enabled")'>
                                                <i class='fa-solid fa-toggle-on false'></i>
                                            </button>
                                        <?php } else { ?>
                                            <button onclick='toggle("true",<?php echo $id[$i] ?>,"enabled")'>
                                                <i class='fa-solid fa-toggle-off false'></i>
                                            </button>
                                        <?php } ?>
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
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
        } else {
            const deleteButton = document.getElementById('delete_selected');
            deleteButton.disabled = true;
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
                    page: 'guests'
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