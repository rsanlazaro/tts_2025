<?php
include '../../includes/templates/header_begin.php';
?>

<link rel="stylesheet" href="../../build/css/app.css" />
<link href="../../assets/css/paper-dashboard.css" rel="stylesheet" />
<link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />

<?php
include '../../includes/templates/header_end.php';
include '../../includes/app.php';
include '../../includes/templates/sessionStart.php';
include '../../includes/templates/validateAccessExternal.php';

// For users fetch information

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

$sql = "SELECT * FROM guests";
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

// For Baby Cloud content generation

if (!($_SESSION['login'])) {
    header('location: /index.php');
}

if (isset($_GET['id'])) {
    $ip_id = $_GET['id'];
}

$sql = "SELECT * FROM guests WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $username_guest = $row['username'];
    $profile_guest = $row['profile'];
}

$counter_enable = 1;

// ----------------- New Stage ----------------- //

$select_options2 = [];

$counter_enable = 1;
$stage = 1;
${"max_{$stage}_components"} = 3;
${"Stage_$stage"} = new stdClass();
$titles = ["","Etapa/descripción", "Estado", "Fecha", "Resultado e Info adicional", "Uploading/Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 78; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

// For the number of stages repetition (located in table 'ipregister_1')
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 3; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
        $propertyName = "stage_count_$i";
        ${"Stage_$stage"}->$propertyName = ${"stage_count_$i"};
    }
}

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = false;
$description = "Creación embrionaria - Reporte <br> Rapport de création embryonnaire";
$select_options = [
    "---" => "---",
    "Processing" => "Processing",
    "Concluding" => "Concluding"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);
echo "vv: ";
echo $counter_enable;

// ---------------- New Component -------------- // 

$component = 2;
$isStage2 = false;
$description = "Reporte Pgta <br> Rapport PGT-A";
$select_options = [
    "---" => "---",
    "Enviado" => "Enviado",
    "Esperando" => "Esperando",
    "Processing" => "Processing",
    "Concluding" => "Concluding"
];
echo "vv: ";
echo $counter_enable;
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);
echo "vv: ";
echo $counter_enable;

// ----------------- New Stage ----------------- //
$counter_enable = 1;
$stage = 2;
${"max_{$stage}_components"} = 6;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$titles = ["","Etapa/descripción", "Resultado", "Fecha", "Resultado e Info adicional", "Uploading/Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 156; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

$table = "ipregister_" . $stage . "_2";
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 157; $i <= 312; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = false;
$description = "Presentación de la candidata <br> Présentation de la candidate";
$select_options = [
    "---" => "---",
    "Selection" => "Selection",
    "Insurance_Period" => "Insurance Period",
    "Start_Simulation" => "Start Simulation",
    "Canceled" => "Canceled",
    "Concluding" => "Concluding"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
$isStage2 = false;
$description = "Transfer. Embrionaria <br> Transfert embryonnaire";
$select_options = [
    "---" => "---",
    "Esperando" => "Esperando",
    "Canceled" => "Canceled",
    "Processing" => "Processing",
    "Concluding" => "Concluding"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
$isStage2 = false;
$description = "Reporte Transfer <br> Rapport de transfert embryonnaire";
$select_options = [
    "---" => "---",
    "Esperando" => "Esperando",
    "Concluding" => "Concluding"
];
$counter_enable_temp = $counter_enable;
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);
$counter_enable = $counter_enable_temp;

// ---------------- New Component -------------- // 
$component = 4;
$isStage2 = false;
$description = "Prueba Beta <br> Beta Test";
$select_options = [
    "---" => "---",
    "Programada" => "Programada",
    "Processing" => "Processing",
    "Concluding" => "Concluding"
];
$select_options2 = [
    "---" => "---",
    "Esperando Beta" => "Esperando Beta",
    "Positivo" => "Positivo",
    "No_Confirmado" => "No Confirmado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 5;
$isStage2 = false;
$description = "Saco gestacional <br> Sac gestationnel";
$select_options = [
    "---" => "---",
    "Programada" => "Programada",
    "Processing" => "Processing",
    "Concluding" => "Concluding"
];
$select_options2 = [
    "---" => "---",
    "Esperando" => "Esperando",
    "Con_Presencia" => "Con Presencia",
    "No_Confirmado" => "No Confirmado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);


// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 3;
${"max_{$stage}_components"} = 3;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$titles = ["Confirmación embarazo - Primer trimestre", "Descripción", "Resultado", "Fecha", "Ícono resumen", "Uploading", "Habilitar", "Uploading", "Habilitar", "Uploading", "Habilitar", "Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 117; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = true;
$description = "SDG8 - Latido de corazón <br> Détection du battement du coeur foetal";
$select_options = [
    "---" => "---",
    "Programada" => "Programada",
    "Esperando_SDG" => "Esperando SDG",
    "Successful" => "Successful",
    "No_Confirmado" => "No Confirmado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
$isStage2 = true;
$description = "SDG10 - Seg Ginecologica <br> Suivi Gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
$isStage2 = true;
$description = "SDG12 - Materno Fetal 1 <br> Suivi Materno Fetal 1";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 4;
${"max_{$stage}_components"} = 1;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 52; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
$isStage2 = true;
$description = "Materno Fetal 2 <br> Suivi Materno Fetal 2";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 4;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 5;
${"max_{$stage}_components"} = 1;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM ipregister_5 WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO ipregister_5 (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 104; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
$isStage2 = true;
$description = "Materno Fetal 3 <br> Suivi Materno Fetal 3";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 4;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 5;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 6;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 7;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ---------------- New Component -------------- // 
$component = 8;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "---" => "---",
    "Estimado" => "Estimado",
    "Programado" => "Programado",
    "Reagendado" => "Reagendado",
    "Cancelado" => "Cancelado",
    "Realizado" => "Realizado"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 6;
${"max_{$stage}_components"} = 1;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 0) {
    $sql = "INSERT INTO $table (id) VALUES (${ip_id})";
    $result = mysqli_query($conn, $sql);
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        for ($i = 1; $i <= 13; $i++) {
            ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
            if (${"stage_{$stage}_{$i}"} === '') {
            }
        }
    }
}
$propertyName = "stage_count_1";
${"Stage_$stage"}->$propertyName = 1;

// ---------------- New Component -------------- // 
$component = 1;
$isStage2 = true;
$description = "Fecha estimada de parto <br> Date probable de naissance";
$select_options = [
    "---" => "---",
    "Esperando_fecha" => "Esperando fecha",
    "Confirmada" => "Confirmada"
];
generateRow($component, $stage, $description, $select_options, $select_options2, $isStage2);

function generateRow(int $component, int $stage, string $description, array $select_options, array $select_options2, bool $isStage2)
{
    global $counter_enable;
    global ${"max_{$stage}_{$component}"};
    global ${"max_{$stage}_components"};
    global ${"stage_{$stage}_{$counter_enable}"};
    ${"info_general_$component"} = [];
    ${"info_1_$component"} = [];
    ${"info_2_$component"} = [];
    ${"uploading_1_$component"} = [];
    ${"uploading_2_$component"} = [];
    ${"uploading_3_$component"} = [];
    ${"underway_$component"} = [];
    ${"description_$component"} = [];
    ${"state_$component"} = [];
    global ${"info_general_$component"};
    global ${"info_1_$component"};
    global ${"info_2_$component"};
    global ${"uploading_1_$component"};
    global ${"uploading_2_$component"};
    global ${"uploading_3_$component"};
    global ${"underway_$component"};
    global ${"add_$component"};
    global ${"enable_1_$component"};
    global ${"enable_2_$component"};
    global ${"enable_3_$component"};
    global ${"enableView_$component"};
    global ${"description_$component"};
    global ${"Stage_$stage"};
    global ${"state_$component"};
    for ($i = 0; $i < ${"max_{$stage}_components"}; $i++) {
        ${"description_$component"}[$i] = $description;
        "<button> </button>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"info_general_$component"}[$i] = "<td onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (isset(${"stage_{$stage}_{$counter_enable}"})) {
            if (strlen(${"stage_{$stage}_{$counter_enable}"}) == 0) {
                ${"stage_{$stage}_{$counter_enable}"} = '-';
            }
        }
        ${"state_$component"}[$i] = ${"stage_{$stage}_{$counter_enable}"};
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (isset(${"stage_{$stage}_{$counter_enable}"})) {
            if (strlen(${"stage_{$stage}_{$counter_enable}"}) == 0) {
                ${"stage_{$stage}_{$counter_enable}"} = '-';
            }
        }
        ${"underway_$component"}[$i] = "<td onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (isset(${"stage_{$stage}_{$counter_enable}"})) {
            if (strlen(${"stage_{$stage}_{$counter_enable}"}) == 0) {
                ${"stage_{$stage}_{$counter_enable}"} = '-';
            }
        }
        if ($description == "Creación embrionaria - Reporte <br> Rapport de création embryonnaire") {
            ${"info_1_$component"}[$i] = "<td class='td-inline-block td-center'> <p>Donante</p> <p onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else if ($description == "Reporte Pgta <br> Rapport PGT-A" || $description == "Transfer. Embrionaria <br> Transfert embryonnaire") {
            ${"info_1_$component"}[$i] = "<td class='td-inline-block td-center'> <p>XX</p> <p onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else if ($description == "Presentación de la candidata <br> Présentation de la candidate") {
            ${"info_1_$component"}[$i] = "<td class='td-center'> <p>Candidata</p></td>";
        } else if ($description == "Reporte Transfer <br> Rapport de transfert embryonnaire") {
            ${"info_1_$component"}[$i] = "<td colspan='2'> <p class='td-info-two-cols' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else {
            if ($isStage2) {
                // ${"info_1_$component"}[$i] = "<td colspan='2'> <p class='td-info-two-cols' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
                if (${"stage_{$stage}_{$counter_enable}"} !== null) {
                    $length = strlen(${"stage_{$stage}_{$counter_enable}"});
                } else {
                    $length = 0;
                }
                if ($length > 1) {
                    ${"info_1_$component"}[$i] = "<td colspan='2' class='td-center td-icon'>" .
                        "<button type='button' data-bs-toggle='modal' data-bs-target='#modal-" . $stage . "-text-" . $counter_enable . "'>
                    <svg class='uploading-true' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots-fill' viewBox='0 0 16 16'>
                        <path d='M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2'/>
                    </svg>
                </button>"
                        . "</td>";
                } else {
                    ${"info_1_$component"}[$i] = "<td colspan='2' class='td-center td-icon'>" .
                        "<button class='icon-disabled' type='button' data-bs-toggle='modal' data-bs-target='#modal-" . $stage . "-text-" . $counter_enable . "'>
                        <svg class='uploading-false' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots-fill' viewBox='0 0 16 16'>
                            <path d='M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2'/>
                        </svg>
                    </button>"
                        . "</td>";
                }
            } else {
                ${"info_1_$component"}[$i] = "<td onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
            }
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (isset(${"stage_{$stage}_{$counter_enable}"})) {
            if (strlen(${"stage_{$stage}_{$counter_enable}"}) == 0) {
                ${"stage_{$stage}_{$counter_enable}"} = '-';
            }
        }
        if ($description == "Creación embrionaria - Reporte <br> Rapport de création embryonnaire") {
            ${"info_2_$component"}[$i] = "<td class='td-inline-block td-center'> <p>Embriones D6</p> <p onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else if ($description == "Reporte Pgta <br> Rapport PGT-A" || $description == "Transfer. Embrionaria <br> Transfert embryonnaire") {
            ${"info_2_$component"}[$i] = "<td class='td-inline-block td-center'> <p>XY</p> <p onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else if ($description == "Presentación de la candidata <br> Présentation de la candidate") {
            ${"info_2_$component"}[$i] = "<td class='td-inline-block td-center'> <p onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</p></td>";
        } else if ($description == "Prueba Beta <br> Beta Test" || $description == "Saco gestacional <br> Sac gestationnel") {
            if (${"stage_{$stage}_{$counter_enable}"} !== null) {
                $length = strlen(${"stage_{$stage}_{$counter_enable}"});
            } else {
                $length = 0;
            }
            if ($length > 1) {
                ${"info_2_$component"}[$i] = "<td class='td-center td-icon'>" .
                    "<button type='button' data-bs-toggle='modal' data-bs-target='#modal-" . $stage . "-text-" . $counter_enable . "'>
                        <svg class='uploading-true' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots-fill' viewBox='0 0 16 16'>
                            <path d='M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2'/>
                        </svg>
                    </button>"
                    . "</td>";
            } else {
                ${"info_2_$component"}[$i] = "<td class='td-center td-icon'>" .
                    "<button type='button' class='icon-disabled' data-bs-toggle='modal' data-bs-target='#modal-" . $stage . "-text-" . $counter_enable . "'>
                        <svg class='uploading-false' xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-chat-dots-fill' viewBox='0 0 16 16'>
                            <path d='M16 8c0 3.866-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7M5 8a1 1 0 1 0-2 0 1 1 0 0 0 2 0m4 0a1 1 0 1 0-2 0 1 1 0 0 0 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2'/>
                        </svg>
                    </button>"
                    . "</td>";
            }
        } else if ($description == "Reporte Transfer <br> Rapport de transfert embryonnaire") {
            ${"info_2_$component"}[$i] = '';
        } else {
            ${"info_2_$component"}[$i] = "<td onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} !== null) {
            $length = strlen(${"stage_{$stage}_{$counter_enable}"});
        } else {
            $length = 0; // Or handle the null case as appropriate
        }
        $counter_enable_2 = $counter_enable + 1;
        global ${"stage_{$stage}_{$counter_enable_2}"};
        if (${"stage_{$stage}_{$counter_enable_2}"} == "true")
        {
            ${"uploading_1_$component"}[$i] = "<td class='td-center td-icon'>
                <a href=" . ${"stage_{$stage}_{$counter_enable}"} . " target='_blank'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-pdf-fill' viewBox='0 0 16 16'>
                    <path d='M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z'/>
                    <path fill-rule='evenodd' d='M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103'/>
                </svg>
                </a>
                </td>";
        } else {
            if ($length > 5) {
                ${"uploading_1_$component"}[$i] = "<td class='td-center'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hourglass-split' viewBox='0 0 16 16'>
                        <path d='M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z'/>
                    </svg>
                    </td>";
            } else {
                ${"uploading_1_$component"}[$i] = "<td class='td-center td-icon'></td>";
            }
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == "true") {
            ${"enable_1_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",true, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-on false'></i>
        </button>";
        } else {
            ${"enable_1_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",false, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-off false'></i>
        </button>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} !== null) {
            $length = strlen(${"stage_{$stage}_{$counter_enable}"});
        } else {
            $length = 0; // Or handle the null case as appropriate
        }
        $counter_enable_2 = $counter_enable + 1;
        global ${"stage_{$stage}_{$counter_enable_2}"};
        if (${"stage_{$stage}_{$counter_enable_2}"} == "true")
        {
            ${"uploading_2_$component"}[$i] = "<td class='td-center td-icon'>
                <a href=" . ${"stage_{$stage}_{$counter_enable}"} . " target='_blank'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-file-earmark-pdf-fill' viewBox='0 0 16 16'>
                    <path d='M5.523 12.424q.21-.124.459-.238a8 8 0 0 1-.45.606c-.28.337-.498.516-.635.572l-.035.012a.3.3 0 0 1-.026-.044c-.056-.11-.054-.216.04-.36.106-.165.319-.354.647-.548m2.455-1.647q-.178.037-.356.078a21 21 0 0 0 .5-1.05 12 12 0 0 0 .51.858q-.326.048-.654.114m2.525.939a4 4 0 0 1-.435-.41q.344.007.612.054c.317.057.466.147.518.209a.1.1 0 0 1 .026.064.44.44 0 0 1-.06.2.3.3 0 0 1-.094.124.1.1 0 0 1-.069.015c-.09-.003-.258-.066-.498-.256M8.278 6.97c-.04.244-.108.524-.2.829a5 5 0 0 1-.089-.346c-.076-.353-.087-.63-.046-.822.038-.177.11-.248.196-.283a.5.5 0 0 1 .145-.04c.013.03.028.092.032.198q.008.183-.038.465z'/>
                    <path fill-rule='evenodd' d='M4 0h5.293A1 1 0 0 1 10 .293L13.707 4a1 1 0 0 1 .293.707V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2m5.5 1.5v2a1 1 0 0 0 1 1h2zM4.165 13.668c.09.18.23.343.438.419.207.075.412.04.58-.03.318-.13.635-.436.926-.786.333-.401.683-.927 1.021-1.51a11.7 11.7 0 0 1 1.997-.406c.3.383.61.713.91.95.28.22.603.403.934.417a.86.86 0 0 0 .51-.138c.155-.101.27-.247.354-.416.09-.181.145-.37.138-.563a.84.84 0 0 0-.2-.518c-.226-.27-.596-.4-.96-.465a5.8 5.8 0 0 0-1.335-.05 11 11 0 0 1-.98-1.686c.25-.66.437-1.284.52-1.794.036-.218.055-.426.048-.614a1.24 1.24 0 0 0-.127-.538.7.7 0 0 0-.477-.365c-.202-.043-.41 0-.601.077-.377.15-.576.47-.651.823-.073.34-.04.736.046 1.136.088.406.238.848.43 1.295a20 20 0 0 1-1.062 2.227 7.7 7.7 0 0 0-1.482.645c-.37.22-.699.48-.897.787-.21.326-.275.714-.08 1.103'/>
                </svg>
                </a>
                </td>";
        } else {
            if ($length > 5) {
                ${"uploading_2_$component"}[$i] = "<td class='td-center'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-hourglass-split' viewBox='0 0 16 16'>
                        <path d='M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z'/>
                    </svg>
                    </td>";
            } else {
                ${"uploading_2_$component"}[$i] = "<td class='td-center td-icon'></td>";
            }
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == "true") {
            ${"enable_2_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",true, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-on false'></i>
        </button>";
        } else {
            ${"enable_2_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",false, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-off false'></i>
        </button>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"uploading_3_$component"}[$i] = "<td class='td-center' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == "true") {
            ${"enable_3_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",true, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-on false'></i>
        </button>";
        } else {
            ${"enable_3_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",false, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-toggle-off false'></i>
        </button>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == "true") {
            ${"enableView_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",true, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-eye false'></i>
        </button>";
        } else {
            ${"enableView_$component"}[$i] =
                "<button onclick='toggle(" . $counter_enable . ",false, " . $stage . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-eye-slash false'></i>
        </button>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
    }
    $propertyName = "add_$component";
    ${"Stage_$stage"}->$propertyName = ${"add_$component"};
    $propertyName = "description_$component";
    ${"Stage_$stage"}->$propertyName = ${"description_$component"};
    $propertyName = "info_general_$component";
    ${"Stage_$stage"}->$propertyName = ${"info_general_$component"};
    $propertyName = "state_$component";
    ${"Stage_$stage"}->$propertyName = ${"state_$component"};
    $propertyName = "underway_$component";
    ${"Stage_$stage"}->$propertyName = ${"underway_$component"};
    $propertyName = "info_1_$component";
    ${"Stage_$stage"}->$propertyName = ${"info_1_$component"};
    $propertyName = "info_2_$component";
    ${"Stage_$stage"}->$propertyName = ${"info_2_$component"};
    $propertyName = "uploading_1_$component";
    ${"Stage_$stage"}->$propertyName = ${"uploading_1_$component"};
    $propertyName = "uploading_2_$component";
    ${"Stage_$stage"}->$propertyName = ${"uploading_2_$component"};
    $propertyName = "uploading_3_$component";
    ${"Stage_$stage"}->$propertyName = ${"uploading_3_$component"};
    $propertyName = "enable_1_$component";
    ${"Stage_$stage"}->$propertyName = ${"enable_1_$component"};
    $propertyName = "enable_2_$component";
    ${"Stage_$stage"}->$propertyName = ${"enable_2_$component"};
    $propertyName = "enable_3_$component";
    ${"Stage_$stage"}->$propertyName = ${"enable_3_$component"};
    $propertyName = "enableView_$component";
    ${"Stage_$stage"}->$propertyName = ${"enableView_$component"};
}

function headerStage($titles)
{
    foreach ($titles as $title) {
        if ($title == "Resultado e Info adicional" || $title == "Datos" || $title == "Ícono resumen") {
            echo "<th colspan='2'> <div class='td-info-title'>" . $title . "</div> </th>";
        } else if ($title == "Uploading/Habilitar Vista") {
            echo "<th colspan='2' class='td-center'>" . "" . "</th>";
        } else {
            echo "<th>" . $title . "</th>";
        }
    }
}

function tableStage(
    $i,
    $description_1,
    $state_1,
    $underway_1,
    $info_1_1,
    $info_2_1,
    $uploading_1_1,
    $enable_1_1,
    $uploading_2_1,
    $enable_2_1,
    $enableView_1
) {
    if (!(str_contains($enableView_1[$i], 'fa-eye-slash'))) {
        if (!($description_1[$i] == "Reporte Transfer <br> Rapport de transfert embryonnaire")) {
            echo "<tr>" .
                ($i == 0 ? "<td class='td-icon td-center td-info'>" .
                        "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'>
                        <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2'/>
                    </svg>" .
                        "</td>" : "<td> </td>") .
                "<td class='description'>" . $description_1[$i] . "</td>" .
                "<td>" . $state_1[$i] . "</td>" .
                $underway_1[$i] .
                $info_1_1[$i] .
                $info_2_1[$i] .
                $uploading_1_1[$i] .
                $uploading_2_1[$i] .
                "</tr>";
        }
    }
}

function tableStage2(
    $i,
    $description_1,
    $state_1,
    $underway_1,
    $info_1_1,
    $uploading_1_1,
    $enable_1_1,
    $uploading_2_1,
    $enable_2_1,
    $enableView_1
) {
    if (!(str_contains($enableView_1[$i], 'fa-eye-slash'))) {
        echo "<tr>" .
            ($i == 0 ? "<td class='td-icon td-center td-info'>" .
                    "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-info-circle-fill' viewBox='0 0 16 16'>
                        <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2'/>
                    </svg>" .
                    "</td>" : "<td> </td>") .
            "<td class='description'>" . $description_1[$i] . "</td>" .
            "<td>" . $state_1[$i] . "</td>" .
            $underway_1[$i] .
            $info_1_1[$i] .
            $uploading_1_1[$i] .
            $uploading_2_1[$i] .
            "</tr>";
    }
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

        </div>
        <div class="lateral-info">
            <div class="logo">
                <a href="../home.php"><img src="../../build/img/logos/babyCloud.webp" alt="Baby Site Logo"></a>
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
                Baby Cloud para el IP <?php echo $username_guest; ?>
            </div>
            <div class="buttons">
            </div>
        </div>
        <div class="babycloud-ip-body">
            <div class="content table-responsive table-scroll table-full-width table-container table-ips">
                <div class="panel">
                    <div class="body">
                        <div class="input-group">
                            <div></div>
                            <?php if ($_SESSION['type'] != 'recluta') { ?>
                                <button onclick="returnIP(<?php $_GET['id'] ?>)">Regresar </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <table class="table table-hover myTable" id="myTable">
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
                        <col>
                    </colgroup>
                    <thead data-bs-toggle="collapse" data-bs-target="#section1" aria-expanded="true" style="cursor: pointer;">
                        <tr class="thead">
                            <th colspan="4">Fase 1 - Crio Embrio</th>
                            <th colspan="3"></th>
                            <th colspan="1">
                                <div class="d-flex justify-content-end me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="section1" class="collapse show">
                        <tr class="thead-2">
                            <?php
                            headerStage($Stage_1->titles);
                            ?>
                        </tr>
                        <?php
                        for ($i = 0; $i < $Stage_1->stage_count_1; $i++) {
                            tableStage(
                                $i,
                                $Stage_1->description_1,
                                $Stage_1->state_1,
                                $Stage_1->underway_1,
                                $Stage_1->info_1_1,
                                $Stage_1->info_2_1,
                                $Stage_1->uploading_1_1,
                                $Stage_1->enable_1_1,
                                $Stage_1->uploading_2_1,
                                $Stage_1->enable_2_1,
                                $Stage_1->enableView_1
                            );
                            tableStage(
                                $i,
                                $Stage_1->description_2,
                                $Stage_1->state_2,
                                $Stage_1->underway_2,
                                $Stage_1->info_1_2,
                                $Stage_1->info_2_2,
                                $Stage_1->uploading_1_2,
                                $Stage_1->enable_1_2,
                                $Stage_1->uploading_2_2,
                                $Stage_1->enable_2_2,
                                $Stage_1->enableView_2
                            );
                            if ($Stage_1->stage_count_1 > 1 && $i !== $Stage_1->stage_count_1 - 1) {
                                echo "<tr class='td-double-border'><td colspan='8'></td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                    <thead data-bs-toggle="collapse" data-bs-target="#section2" aria-expanded="true" style="cursor: pointer;">
                        <tr class="thead">
                            <th colspan="4">Fase 2 - Intentos de embarazo</th>
                            <th colspan="3"></th>
                            <th colspan="1">
                                <div class="d-flex justify-content-end me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="section2" class="collapse show">
                        <tr class="thead-2">
                            <?php
                            headerStage($Stage_2->titles);
                            ?>
                        </tr>
                        <?php
                        for ($i = 0; $i < $Stage_1->stage_count_2; $i++) {
                            tableStage(
                                $i,
                                $Stage_2->description_1,
                                $Stage_2->state_1,
                                $Stage_2->underway_1,
                                $Stage_2->info_1_1,
                                $Stage_2->info_2_1,
                                $Stage_2->uploading_1_1,
                                $Stage_2->enable_1_1,
                                $Stage_2->uploading_2_1,
                                $Stage_2->enable_2_1,
                                $Stage_2->enableView_1
                            );
                            tableStage(
                                $i,
                                $Stage_2->description_2,
                                $Stage_2->state_2,
                                $Stage_2->underway_2,
                                $Stage_2->info_1_2,
                                $Stage_2->info_2_2,
                                $Stage_2->uploading_1_2,
                                $Stage_2->enable_1_2,
                                $Stage_2->uploading_2_2,
                                $Stage_2->enable_2_2,
                                $Stage_2->enableView_2
                            );
                            tableStage(
                                $i,
                                $Stage_2->description_3,
                                $Stage_2->state_3,
                                $Stage_2->underway_3,
                                $Stage_2->info_1_3,
                                $Stage_2->info_2_3,
                                $Stage_2->uploading_1_3,
                                $Stage_2->enable_1_3,
                                $Stage_2->uploading_2_3,
                                $Stage_2->enable_2_3,
                                $Stage_2->enableView_3
                            );
                            tableStage(
                                $i,
                                $Stage_2->description_4,
                                $Stage_2->state_4,
                                $Stage_2->underway_4,
                                $Stage_2->info_1_4,
                                $Stage_2->info_2_4,
                                $Stage_2->uploading_1_4,
                                $Stage_2->enable_1_4,
                                $Stage_2->uploading_2_4,
                                $Stage_2->enable_2_4,
                                $Stage_2->enableView_4
                            );
                            tableStage(
                                $i,
                                $Stage_2->description_5,
                                $Stage_2->state_5,
                                $Stage_2->underway_5,
                                $Stage_2->info_1_5,
                                $Stage_2->info_2_5,
                                $Stage_2->uploading_1_5,
                                $Stage_2->enable_1_5,
                                $Stage_2->uploading_2_5,
                                $Stage_2->enable_2_5,
                                $Stage_2->enableView_5
                            );
                            if ($Stage_1->stage_count_2 > 1 && $i !== $Stage_1->stage_count_2 - 1) {
                                echo "<tr class='td-double-border'><td colspan='8'></td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                    <thead data-bs-toggle="collapse" data-bs-target="#section3" aria-expanded="true" style="cursor: pointer;">
                        <tr class="thead">
                            <th colspan="4">Fase 3 - Seguimiento Ginecológico</th>
                            <th colspan="3"></th>
                            <th colspan="1">
                                <div class="d-flex justify-content-end me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="section3" class="collapse show">
                        <tr class="thead-2">
                            <th colspan="8">Seguimiento Ginecológico - Primer Trimestre</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < $Stage_1->stage_count_3; $i++) {
                            tableStage2(
                                $i,
                                $Stage_3->description_1,
                                $Stage_3->state_1,
                                $Stage_3->underway_1,
                                $Stage_3->info_1_1,
                                $Stage_3->uploading_1_1,
                                $Stage_3->enable_1_1,
                                $Stage_3->uploading_2_1,
                                $Stage_3->enable_2_1,
                                $Stage_3->enableView_1
                            );
                            tableStage2(
                                $i,
                                $Stage_3->description_2,
                                $Stage_3->state_2,
                                $Stage_3->underway_2,
                                $Stage_3->info_1_2,
                                $Stage_3->uploading_1_2,
                                $Stage_3->enable_1_2,
                                $Stage_3->uploading_2_2,
                                $Stage_3->enable_2_2,
                                $Stage_3->enableView_2
                            );
                            tableStage2(
                                $i,
                                $Stage_3->description_3,
                                $Stage_3->state_3,
                                $Stage_3->underway_3,
                                $Stage_3->info_1_3,
                                $Stage_3->uploading_1_3,
                                $Stage_3->enable_1_3,
                                $Stage_3->uploading_2_3,
                                $Stage_3->enable_2_3,
                                $Stage_3->enableView_3
                            );
                            if ($Stage_1->stage_count_3 > 1 && $i !== $Stage_1->stage_count_3 - 1) {
                                echo "<tr class='td-double-border'><td colspan='8'></td></tr>";
                            }
                        }
                        ?>
                    </tbody>
                    <thead data-bs-toggle="collapse" data-bs-target="#section4" aria-expanded="true" style="cursor: pointer;">
                        <tr class="thead">
                            <th colspan="7">Fase 4 - Conclusión</th>
                            <th colspan="1">
                                <div class="d-flex justify-content-end me-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody id="section4" class="collapse show">
                        <tr class="thead-2">
                            <th colspan="8">Seguimiento Ginecológico - Segundo Trimestre</th>
                        </tr>
                        <?php
                        tableStage2(
                            0,
                            $Stage_4->description_1,
                            $Stage_4->state_1,
                            $Stage_4->underway_1,
                            $Stage_4->info_1_1,
                            $Stage_4->uploading_1_1,
                            $Stage_4->enable_1_1,
                            $Stage_4->uploading_2_1,
                            $Stage_4->enable_2_1,
                            $Stage_4->enableView_1
                        );
                        tableStage2(
                            0,
                            $Stage_4->description_2,
                            $Stage_4->state_2,
                            $Stage_4->underway_2,
                            $Stage_4->info_1_2,
                            $Stage_4->uploading_1_2,
                            $Stage_4->enable_1_2,
                            $Stage_4->uploading_2_2,
                            $Stage_4->enable_2_2,
                            $Stage_4->enableView_2
                        );
                        tableStage2(
                            0,
                            $Stage_4->description_3,
                            $Stage_4->state_3,
                            $Stage_4->underway_3,
                            $Stage_4->info_1_3,
                            $Stage_4->uploading_1_3,
                            $Stage_4->enable_1_3,
                            $Stage_4->uploading_2_3,
                            $Stage_4->enable_2_3,
                            $Stage_4->enableView_3
                        );
                        tableStage2(
                            0,
                            $Stage_4->description_4,
                            $Stage_4->state_4,
                            $Stage_4->underway_4,
                            $Stage_4->info_1_4,
                            $Stage_4->uploading_1_4,
                            $Stage_4->enable_1_4,
                            $Stage_4->uploading_2_4,
                            $Stage_4->enable_2_4,
                            $Stage_4->enableView_4
                        );
                        ?>
                        <tr class="thead-2">
                            <th colspan="8">Seguimiento Ginecológico - Tercer Trimestre > Parto</th>
                        </tr>
                        <?php
                        tableStage2(
                            0,
                            $Stage_5->description_1,
                            $Stage_5->state_1,
                            $Stage_5->underway_1,
                            $Stage_5->info_1_1,
                            $Stage_5->uploading_1_1,
                            $Stage_5->enable_1_1,
                            $Stage_5->uploading_2_1,
                            $Stage_5->enable_2_1,
                            $Stage_5->enableView_1
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_2,
                            $Stage_5->state_2,
                            $Stage_5->underway_2,
                            $Stage_5->info_1_2,
                            $Stage_5->uploading_1_2,
                            $Stage_5->enable_1_2,
                            $Stage_5->uploading_2_2,
                            $Stage_5->enable_2_2,
                            $Stage_5->enableView_2
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_3,
                            $Stage_5->state_3,
                            $Stage_5->underway_3,
                            $Stage_5->info_1_3,
                            $Stage_5->uploading_1_3,
                            $Stage_5->enable_1_3,
                            $Stage_5->uploading_2_3,
                            $Stage_5->enable_2_3,
                            $Stage_5->enableView_3
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_4,
                            $Stage_5->state_4,
                            $Stage_5->underway_4,
                            $Stage_5->info_1_4,
                            $Stage_5->uploading_1_4,
                            $Stage_5->enable_1_4,
                            $Stage_5->uploading_2_4,
                            $Stage_5->enable_2_4,
                            $Stage_5->enableView_4
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_5,
                            $Stage_5->state_5,
                            $Stage_5->underway_5,
                            $Stage_5->info_1_5,
                            $Stage_5->uploading_1_5,
                            $Stage_5->enable_1_5,
                            $Stage_5->uploading_2_5,
                            $Stage_5->enable_2_5,
                            $Stage_5->enableView_5
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_6,
                            $Stage_5->state_6,
                            $Stage_5->underway_6,
                            $Stage_5->info_1_6,
                            $Stage_5->uploading_1_6,
                            $Stage_5->enable_1_6,
                            $Stage_5->uploading_2_6,
                            $Stage_5->enable_2_6,
                            $Stage_5->enableView_6
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_7,
                            $Stage_5->state_7,
                            $Stage_5->underway_7,
                            $Stage_5->info_1_7,
                            $Stage_5->uploading_1_7,
                            $Stage_5->enable_1_7,
                            $Stage_5->uploading_2_7,
                            $Stage_5->enable_2_7,
                            $Stage_5->enableView_7
                        );
                        tableStage2(
                            0,
                            $Stage_5->description_8,
                            $Stage_5->state_8,
                            $Stage_5->underway_8,
                            $Stage_5->info_1_8,
                            $Stage_5->uploading_1_8,
                            $Stage_5->enable_1_8,
                            $Stage_5->uploading_2_8,
                            $Stage_5->enable_2_8,
                            $Stage_5->enableView_8
                        );
                        tableStage2(
                            0,
                            $Stage_6->description_1,
                            $Stage_6->state_1,
                            $Stage_6->underway_1,
                            $Stage_6->info_1_1,
                            $Stage_6->uploading_1_1,
                            $Stage_6->enable_1_1,
                            $Stage_6->uploading_2_1,
                            $Stage_6->enable_2_1,
                            $Stage_6->enableView_1
                        );
                        ?>
                        <?php for ($j = 0; $j <= 6; $j++) { ?>
                            <?php for ($i = 0; $i < 500; $i++) { ?>
                                <div class="modal fade" id="modal-<?php echo $j; ?>-<?php echo $i; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $j; ?>-<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-<?php echo $j; ?>-<?php echo $i; ?>">Ingrese el enlace:</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="editable-paragraph" id="editableParagraph-<?php echo $j; ?>-<?php echo $i; ?>" onkeyup="saveContent(this,<?php echo $j; ?>,<?php echo $i; ?>)" contenteditable="true">
                                                    <?php echo ${"stage_{$j}_{$i}"} ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php for ($j = 0; $j <= 6; $j++) { ?>
                            <?php for ($i = 0; $i < 500; $i++) { ?>
                                <div class="modal fade" id="modal-<?php echo $j; ?>-text-<?php echo $i; ?>" tabindex="-1" aria-labelledby="modalLabel-<?php echo $j; ?>-<?php echo $i; ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-<?php echo $j; ?>-<?php echo $i; ?>">Ingrese la información:</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="editable-paragraph" id="editableParagraph-<?php echo $j; ?>-<?php echo $i; ?>" onkeyup="saveContent(this,<?php echo $j; ?>,<?php echo $i; ?>)" contenteditable="true">
                                                    <?php echo ${"stage_{$j}_{$i}"} ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
<!-- Table styling -->
<script>
    const editField = document.querySelectorAll('.td-info-two-cols');
    editField.forEach(td => {
        const text = td.innerText;
        if (text === '-') {
            td.innerHTML = "<p class='td-italic'>Redactar resumen...</p>";
        }
    });
</script>
<!-- Communication with DB -->
<script>
    function toggle(id, state, stage, row = 0, row_num = 0, row_max = 0) {

        const icon = document.getElementById('toggleIcon_off_' + stage + '_' + id);
        icon.classList.add('icon-animate');

        setTimeout(() => {
            if (icon.className.split(" ")[1] == "fa-eye" || icon.className.split(" ")[1] == "fa-eye-slash") {
                if (state) {
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                } else {
                    icon.classList.toggle('fa-eye-slash');
                    icon.classList.toggle('fa-eye');
                }
            } else if (icon.className.split(" ")[1] == "fa-toggle-on" || icon.className.split(" ")[1] == "fa-toggle-off") {
                if (state) {
                    icon.classList.toggle('fa-toggle-on');
                    icon.classList.toggle('fa-toggle-off');
                } else {
                    icon.classList.toggle('fa-toggle-off');
                    icon.classList.toggle('fa-toggle-on');
                }
            }
        }, 150);
        let newValue = '-';

        // // Remove animation class after it's done
        setTimeout(() => {
            icon.classList.remove('icon-animate');
        }, 300);
        if (row == 0) {
            (state == true) ? newValue = 'false': newValue = 'true';
        } else {
            if (row_num == row_max) {
                newValue = 'false';
            } else if (row_num == 1) {
                newValue = 'true';
            } else {
                newValue = String(state);
            }
        }
        fetchContent(id, newValue, stage, row, row_max);
        location.reload();
    };

    function saveContent(tdElement, stage, id) {
        const newValue = tdElement.innerText;
        const row = 0;
        const row_max = "";
        fetchContent(id, newValue, stage, row, row_max);
    }

    function saveContent2(tdElement, stage, id) {
        const newValue = document.getElementById(stage + '_' + id).value;
        const row = 0;
        const row_max = "";
        fetchContent(id, newValue, stage, row, row_max);
    }

    function saveContentDate(tdElement, stage, id) {
        const newValue = document.getElementById(id).value;
        const row = 0;
        const row_max = "";
        fetchContent(id, newValue, stage, row, row_max);
    }

    function saveContentPhase(action, stage) {
        const urlParams = new URLSearchParams(window.location.search);
        const id_ip = urlParams.get('id');
        fetch('sort_ipBack.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: action,
                    stage: stage,
                    id_ip: id_ip,
                })
            })
            .then(res => res.text()) // expect plain text for echo
            .then(data => {
                console.log('Server responded with:', data);
            })
            .catch(error => console.error('Error:', error));
        location.reload();
    }

    function fetchContent(id, newValue, stage, row, row_max) {
        const urlParams = new URLSearchParams(window.location.search);
        const id_ip = urlParams.get('id');
        fetch('sort_ipBack.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id,
                    content: newValue,
                    stage: stage,
                    row: row,
                    row_max: row_max,
                    id_ip: id_ip
                })
            })
            .then(res => res.text()) // expect plain text for echo
            .then(data => {
                console.log('Server responded with:', data);
            })
            .catch(error => console.error('Error:', error));
    }
    // Preview IP function
    function returnIP(id) {
        const urlParams = new URLSearchParams(window.location.search);
        const id_ip = urlParams.get('id');
        window.location.href = `../babySites/baby_cloud_upload/sort_ip.php?id=${id_ip}`;
    }
</script>
</body>

</html>