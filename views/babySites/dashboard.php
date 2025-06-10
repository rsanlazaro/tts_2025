<?php
include '../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../build/css/app.css" />
<link href="../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../includes/templates/header_end.php';
include '../../includes/app.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = connectDB();

$id_user = $_GET['user'] ?? $_SESSION['id'] ?? null;

$sql = "SELECT * FROM users WHERE id=${id_user}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $username_user = $row['username'];
    $profile_user = $row['profile'];
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
            <img style="cursor:pointer;" onclick="toggleDropdown()" src="../../build/img/testImg/profilepic.webp" alt="Profile Picture">
            <div id="myDropdown-profile" class="dropdown-content-profile">
                <a href="../../logout.php">Cerrar sesión
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
                <img class="icon-img" src="../../build/img/icons/babySite-admin.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">PRO GESTOR</div>
                    <a class="dropdown-item" href="users.php">Listado de Usuarios</a>
                    <a class="dropdown-item" href="#">Listado de Externos</a>
                    <a class="dropdown-item" href="#">Listado de Pagos</a>
                    <a class="dropdown-item" href="#">Listado de Notas</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../build/img/icons/babySite-user.webp" alt="icon">
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
                <img class="icon-img" src="../../build/img/icons/babySite-recluta.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">RECLUTA</div>
                    <a class="dropdown-item" href="#">Nueva Candidata</a>
                    <a class="dropdown-item" href="#">Nueva Donante</a>
                    <a class="dropdown-item" href="#">Mi Listado</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
            <div href="#" class="icon-container">
                <img class="icon-img" src="../../build/img/icons/babySite-upload.webp" alt="icon">
                <div class="dropdown">
                    <div class="dropdown-title">BABY CLOUD UPLOAD</div>
                    <a class="dropdown-item" href="#">Listado Cloud_IPS</a>
                    <a class="dropdown-item" href="#">Listado Cloud_GES</a>
                    <a class="dropdown-item" href="#">Dash Boards</a>
                </div>
            </div>
        </div>
        <div class="lateral-info">
            <div class="logo">
                <img src="../../build/img/logos/babySite.webp" alt="Baby Site Logo">
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
                Bienvenido, <?php echo $name_user; ?>
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
    </div>
</main>

<!-- Boostrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Custom JS -->
<script src="build/js/bundle.min.js"></script>
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