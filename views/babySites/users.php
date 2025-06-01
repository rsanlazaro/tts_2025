<?php
include '../../includes/templates/header_begin.php';
?>
<link rel="stylesheet" href="../../build/css/app.css" />
<?php
include '../../includes/templates/header_end.php';
include "../../includes/app.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = connectDB();

if (!($_SESSION['login'])) {
    header('location: /index.php');
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
$index = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $id[++$index] = $row['id'];
    $user[$index] = $row['username'];
    $pass[$index] = $row['password'];
    $profile[$index] = $row['profile'];
}

?>

<main class="register">
    <div class="register-info">
        <h3>Perfiles registrados</h3>
    </div>

    <?php if (isset($_GET['msg'])) { ?>

        <p class="error"><?php echo $_GET['msg']; ?></p>

    <?php } ?>

    <p>Hay un total de <?php echo $index ?> Perfiles registrados</p>
    <div class="menu-users">
        <div class="create-user">
            <a href="registrationUser.php">
                Nuevo Perfil
            </a>
        </div>
        <div class="logout">
            <a href="logout.php">
                Cerrar sesión
            </a>
        </div>
    </div>

    <div class="lab-pagination table-container">
        <div class="panel">
            <div class="body">
                <div class="input-group">
                    <label for="searchBox">Búsqueda</label>
                    <input type="search" id="searchBox" placeholder="Filtrar..." />
                </div>
            </div>
        </div>
        <table class="responsive-table myTable table hover" id="myTable">
            <thead>
                <tr class="thead">
                    <th onclick="sortTable(0)">Usuario</th>
                    <th onclick="sortTable(1)">Password</th>
                    <th onclick="sortTable(2)">Perfil</th>
                    <th colspan="2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= $index; $i++) { ?>
                    <?php if ($user[$i] != 'SaludConceptAdmin') { ?>
                        <tr>
                            <td data-title="Nombre de usuario" scope="row"><?php echo $user[$i] ?></td>
                            <td data-title="Contraseña"><?php echo $pass[$i] ?></td>
                            <td data-title="Perfil"><?php if ($profile[$i] == "user") { echo "reclutadora"; } else { echo $profile[$i]; } ?></td>
                            <td>
                                <a href="user.php?id=<?php echo $id[$i]; ?>">Editar</a>
                            </td>
                            <td>
                                <form method="POST" class="form-table" action="deleteUser.php">
                                    <input type="hidden" name="id" value="<?php echo $id[$i]; ?>">
                                    <input type="hidden" name="user" value="<?php echo $user[$i]; ?>">
                                    <input type="submit" onclick="return confirm('¿Deseas eliminar al usuario?')" class="boton-rojo-block" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script language="JavaScript" type="text/javascript">
        function checkDelete() {
            return confirm('Are you sure?');
        }
    </script>
    <!-- Custom JS -->
    <script src="../../build/js/paginationFilter.min.js"></script>
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
    </script>

    <script>
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
</main>