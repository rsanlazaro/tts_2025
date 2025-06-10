<?php
include 'includes/templates/header_begin.php';
?>
<link rel="stylesheet" href="build/css/app.css" />
<?php
include 'includes/templates/header_end.php';
include "includes/app.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$conn = connectDB();

if (!($_SESSION['login'])) {
    header('location: /index.php');
}

if (isset($_GET['id'])) {
    $ip_id = $_GET['id'];
}

$counter_enable = 1;

// ----------------- New Stage ----------------- //

$stage = 1;
${"Stage_$stage"} = new stdClass();
$titles = ["Agregar", "Crio embrio", "General Info", "Estado", "Underway", "Info", "Uploading", "Habilitar", "Uploading", "Habilitar", "Uploading", "Habilitar", "Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 200; $i++) {
        ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
    }
}
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 2; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
        $propertyName = "stage_count_$i";
        ${"Stage_$stage"}->$propertyName = ${"stage_count_$i"};
    }
}

// ---------------- New Component -------------- // 
$component = 1;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Creación embrionaria - Reporte <br> Rapport de création embryonnaire";
$select_options = [
    "processing" => "Processing",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_1->stage_count_1, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 

$component = 2;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Reporte Pgta <br> Rapport PGT-A";
$select_options = [
    "waiting" => "Esperando",
    "sent" => "Enviado",
    "processing" => "Processing",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_1->stage_count_2, $description, $select_options, $isStage2);


// ----------------- New Stage ----------------- //
$counter_enable = 1;
$stage = 2;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$titles = ["Agregar", "Preparación Endometrial > Transferencia", "General Info", "Resultado", "Underway", "Datos", "Uploading", "Habilitar", "Uploading", "Habilitar", "Uploading", "Habilitar", "Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 200; $i++) {
        ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
    }
}
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 5; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
        $propertyName = "stage_count_$i";
        ${"Stage_$stage"}->$propertyName = ${"stage_count_$i"};
    }
}

// ---------------- New Component -------------- // 
$component = 1;
${"max_{$stage}_{$component}"} = 1;
$isStage2 = false;
$description = "Presentación de la candidata <br> Présentation de la candidate";
$select_options = [
    "selection" => "Selection",
    "insurance" => "Insurance Period",
    "start" => "Start Simulation",
    "canceled" => "Canceled",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_2->stage_count_1, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Transfer. Embrionaria <br> Transfert embryonnaire";
$select_options = [
    "canceled" => "Canceled",
    "underway" => "Underway",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_2->stage_count_2, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Reporte Transfer <br> Rapport de transfert embryonnaire";
$select_options = [
    "waiting" => "Esperando",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_2->stage_count_3, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 4;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Prueba Beta <br> Beta Test";
$select_options = [
    "waiting" => "Esperando",
    "concluding" => "Concluding"
];
generateRow($component, $stage, $Stage_2->stage_count_4, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 5;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = false;
$description = "Saco gestacional <br> Sac gestationnel";
$select_options = [
    "yes" => "Con presencia",
    "no" => "Sin presencia"
];
generateRow($component, $stage, $Stage_2->stage_count_5, $description, $select_options, $isStage2);


// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 3;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$titles = ["Agregar", "Confirmación embarazo - Primer trimestre", "Descripción", "Resultado", "Underway", "Ícono resumen", "Uploading", "Habilitar", "Uploading", "Habilitar", "Uploading", "Habilitar", "Habilitar Vista"];
${"Stage_$stage"}->titles = $titles;
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 200; $i++) {
        ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
    }
}
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
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "SDG8 - Latido de corazón <br> Détection du battement du coeur foetal";
$select_options = [
    "waiting" => "Esperando SDG",
    "successful" => "Successful",
    "notconfirmed" => "No Confirmado"
];
generateRow($component, $stage, $Stage_3->stage_count_1, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "SDG10 - Seg Ginecologica <br> Suivi Gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_3->stage_count_2, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "SDG12 - Materno Fetal 1 <br> Suivi Materno Fetal 1";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_3->stage_count_3, $description, $select_options, $isStage2);

// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 4;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 200; $i++) {
        ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
    }
}
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 4; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
        $propertyName = "stage_count_$i";
        ${"Stage_$stage"}->$propertyName = ${"stage_count_$i"};
    }
}

// ---------------- New Component -------------- // 
$component = 1;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_4->stage_count_1, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_4->stage_count_2, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Materno Fetal 2 <br> Suivi Materno Fetal 2";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_4->stage_count_3, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 4;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_4->stage_count_4, $description, $select_options, $isStage2);

// ----------------- New Stage ----------------- //

$counter_enable = 1;
$stage = 5;
$prev_stage = $stage - 1;
${"Stage_$stage"} = new stdClass();
$table = "ipregister_" . $stage;
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 200; $i++) {
        ${"stage_{$stage}_{$i}"} = $row['stage_' . $i];
    }
}
$sql = "SELECT * FROM $table WHERE id=${ip_id}";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    for ($i = 1; $i <= 8; $i++) {
        ${"stage_count_$i"} = $row['stage_count_' . $i];
        $propertyName = "stage_count_$i";
        ${"Stage_$stage"}->$propertyName = ${"stage_count_$i"};
    }
}

// ---------------- New Component -------------- // 
$component = 1;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_1, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 2;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Materno Fetal 3 <br> Suivi Materno Fetal 3";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_2, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 3;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_3, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 4;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_4, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 5;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_5, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 6;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_6, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 7;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_7, $description, $select_options, $isStage2);

// ---------------- New Component -------------- // 
$component = 8;
${"max_{$stage}_{$component}"} = 2;
$isStage2 = true;
$description = "Seg Ginecológica <br> Suivi gynécologique";
$select_options = [
    "none" => "---",
    "programmed" => "Programada",
    "canceled" => "Cancelada",
    "done" => "Realizada"
];
generateRow($component, $stage, $Stage_5->stage_count_8, $description, $select_options, $isStage2);

function generateRow(int $component, int $stage, int $row_num, string $description, array $select_options, bool $isStage2)
{
    global $counter_enable;
    global ${"max_{$stage}_{$component}"};
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
    for ($i = 0; $i < ${"max_{$stage}_{$component}"}; $i++) {
        ${"description_$component"}[$i] = $description;
        if ($i == 0) {
            if (${"stage_{$stage}_{$counter_enable}"} == '-' || ${"stage_{$stage}_{$counter_enable}"} == "true") {
                ${"add_$component"}[0] =
                    "<button class='addBtn' onclick='toggle(" . $counter_enable . ",true, " . $stage . "," . $component . ", " . $row_num . "," . ${"max_{$stage}_{$component}"} . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-plus false'></i>
        </button>";
            } else {
                ${"add_$component"}[0] =
                    "<button class='addBtn' onclick='toggle(" . $counter_enable . ",false, " . $stage . "," . $component . ", " . $row_num . "," . ${"max_{$stage}_{$component}"} . ")'>
                <i id='toggleIcon_off_" . $stage . "_" . $counter_enable . "' class='fa-solid fa-minus false'></i>
        </button>";
            }
        } else {
            "<button> </button>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"info_general_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"state_$component"}[$i] = "<select id='" . $stage . "_" . $counter_enable . "' onchange='saveContent2(this," . $stage . "," . $counter_enable . ")'>";
        $state_variable = "";
        foreach ($select_options as $key => $value) {
            $state_variable .= "<option " . (${"stage_{$stage}_{$counter_enable}"} === $key ? "selected" : "") . " value=$key> " .
                $value .
                "</option>";
        }
        ${"state_$component"}[$i] .= $state_variable . "</select>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"underway_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if ($isStage2) {
            ${"info_1_$component"}[$i] = "<td colspan='2' contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        } else {
            ${"info_1_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        }
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"info_2_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        ${"uploading_1_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == '-' || ${"stage_{$stage}_{$counter_enable}"} == "true") {
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
        ${"uploading_2_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == '-' || ${"stage_{$stage}_{$counter_enable}"} == "true") {
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
        ${"uploading_3_$component"}[$i] = "<td contenteditable='true' onkeyup='saveContent(this," . $stage . "," . $counter_enable . ")'>" . ${"stage_{$stage}_{$counter_enable}"} . "</td>";
        $counter_enable++;
        global ${"stage_{$stage}_{$counter_enable}"};
        if (${"stage_{$stage}_{$counter_enable}"} == '-' || ${"stage_{$stage}_{$counter_enable}"} == "true") {
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
        if (${"stage_{$stage}_{$counter_enable}"} == '-' || ${"stage_{$stage}_{$counter_enable}"} == "true") {
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
        if ($title == "Info" || $title == "Datos" || $title == "Ícono resumen") {
            echo "<th colspan='2'>" . $title . "</th>";
        } else {
            echo "<th>" . $title . "</th>";
        }
    }
}

function tableStage(
    $stage_count_1,
    $add_1,
    $description_1,
    $info_general_1,
    $state_1,
    $underway_1,
    $info_1_1,
    $info_2_1,
    $uploading_1_1,
    $enable_1_1,
    $uploading_2_1,
    $enable_2_1,
    $uploading_3_1,
    $enable_3_1,
    $enableView_1
) {
    for ($x = 0; $x < $stage_count_1; $x++) {
        echo "<tr>" .
            ($x == 0 ? "<td class='add'>" . $add_1[$x] . "</td>" : "<td class='add'> </td>") .
            "<td class='description'>" . $description_1[$x] . "</td>" .
            $info_general_1[$x] .
            "<td>" . $state_1[$x] . "</td>" .
            $underway_1[$x] .
            $info_1_1[$x] .
            $info_2_1[$x] .
            $uploading_1_1[$x] .
            "<td class='enable_1'>" . $enable_1_1[$x] . "</td>" .
            $uploading_2_1[$x] .
            "<td class='enable_2'>" . $enable_2_1[$x] . "</td>" .
            $uploading_3_1[$x] .
            "<td class='enable_3'>" . $enable_3_1[$x] . "</td>" .
            "<td class='enableView'>" . $enableView_1[$x] . "</td>" .
            "</tr>";
    }
}

function tableStage2(
    $stage_count_1,
    $add_1,
    $description_1,
    $info_general_1,
    $state_1,
    $underway_1,
    $info_1_1,
    $uploading_1_1,
    $enable_1_1,
    $uploading_2_1,
    $enable_2_1,
    $uploading_3_1,
    $enable_3_1,
    $enableView_1
) {
    for ($x = 0; $x < $stage_count_1; $x++) {
        echo "<tr>" .
            ($x == 0 ? "<td class='add'>" . $add_1[$x] . "</td>" : "<td class='add'> </td>") .
            "<td class='description'>" . $description_1[$x] . "</td>" .
            $info_general_1[$x] .
            "<td>" . $state_1[$x] . "</td>" .
            $underway_1[$x] .
            $info_1_1[$x] .
            $uploading_1_1[$x] .
            "<td class='enable_1'>" . $enable_1_1[$x] . "</td>" .
            $uploading_2_1[$x] .
            "<td class='enable_2'>" . $enable_2_1[$x] . "</td>" .
            $uploading_3_1[$x] .
            "<td class='enable_3'>" . $enable_3_1[$x] . "</td>" .
            "<td class='enableView'>" . $enableView_1[$x] . "</td>" .
            "</tr>";
    }
}

?>

<main class="ips-register">
    <div class="content table-responsive table-full-width table-scroll table-container">
        <table class="table table-hover myTable" id="myTable">
            <thead class="table-light" data-bs-toggle="collapse" data-bs-target="#section1" aria-expanded="true" style="cursor: pointer;">
                <tr class="thead">
                    <th colspan="14">Fase 1 - Crio Embrio</th>
                </tr>
            </thead>
            <tbody id="section1" class="collapse show">
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
                    <col>
                    <col>
                    <col>
                    <col>
                </colgroup>
                <tr class="thead">
                    <?php
                    headerStage($Stage_1->titles);
                    ?>
                </tr>
                <?php
                tableStage(
                    $Stage_1->stage_count_1,
                    $Stage_1->add_1,
                    $Stage_1->description_1,
                    $Stage_1->info_general_1,
                    $Stage_1->state_1,
                    $Stage_1->underway_1,
                    $Stage_1->info_1_1,
                    $Stage_1->info_2_1,
                    $Stage_1->uploading_1_1,
                    $Stage_1->enable_1_1,
                    $Stage_1->uploading_2_1,
                    $Stage_1->enable_2_1,
                    $Stage_1->uploading_3_1,
                    $Stage_1->enable_3_1,
                    $Stage_1->enableView_1
                );
                tableStage(
                    $Stage_1->stage_count_2,
                    $Stage_1->add_2,
                    $Stage_1->description_2,
                    $Stage_1->info_general_2,
                    $Stage_1->state_2,
                    $Stage_1->underway_2,
                    $Stage_1->info_1_2,
                    $Stage_1->info_2_2,
                    $Stage_1->uploading_1_2,
                    $Stage_1->enable_1_2,
                    $Stage_1->uploading_2_2,
                    $Stage_1->enable_2_2,
                    $Stage_1->uploading_3_2,
                    $Stage_1->enable_3_2,
                    $Stage_1->enableView_2
                );
                ?>
            </tbody>
            <thead class="table-light" data-bs-toggle="collapse" data-bs-target="#section2" aria-expanded="true" style="cursor: pointer;">
                <tr class="thead">
                    <th colspan="14">Fase 2.1 - Intentos de embarazo</th>
                </tr>
            </thead>
            <tbody id="section2" class="collapse show">
                <tr class="thead">
                    <?php
                    headerStage($Stage_2->titles);
                    ?>
                </tr>
                <?php
                tableStage(
                    $Stage_2->stage_count_1,
                    $Stage_2->add_1,
                    $Stage_2->description_1,
                    $Stage_2->info_general_1,
                    $Stage_2->state_1,
                    $Stage_2->underway_1,
                    $Stage_2->info_1_1,
                    $Stage_2->info_2_1,
                    $Stage_2->uploading_1_1,
                    $Stage_2->enable_1_1,
                    $Stage_2->uploading_2_1,
                    $Stage_2->enable_2_1,
                    $Stage_2->uploading_3_1,
                    $Stage_2->enable_3_1,
                    $Stage_2->enableView_1
                );
                tableStage(
                    $Stage_2->stage_count_2,
                    $Stage_2->add_2,
                    $Stage_2->description_2,
                    $Stage_2->info_general_2,
                    $Stage_2->state_2,
                    $Stage_2->underway_2,
                    $Stage_2->info_1_2,
                    $Stage_2->info_2_2,
                    $Stage_2->uploading_1_2,
                    $Stage_2->enable_1_2,
                    $Stage_2->uploading_2_2,
                    $Stage_2->enable_2_2,
                    $Stage_2->uploading_3_2,
                    $Stage_2->enable_3_2,
                    $Stage_2->enableView_2
                );
                tableStage(
                    $Stage_2->stage_count_3,
                    $Stage_2->add_3,
                    $Stage_2->description_3,
                    $Stage_2->info_general_3,
                    $Stage_2->state_3,
                    $Stage_2->underway_3,
                    $Stage_2->info_1_3,
                    $Stage_2->info_2_3,
                    $Stage_2->uploading_1_3,
                    $Stage_2->enable_1_3,
                    $Stage_2->uploading_2_3,
                    $Stage_2->enable_2_3,
                    $Stage_2->uploading_3_3,
                    $Stage_2->enable_3_3,
                    $Stage_2->enableView_3
                );
                tableStage(
                    $Stage_2->stage_count_4,
                    $Stage_2->add_4,
                    $Stage_2->description_4,
                    $Stage_2->info_general_4,
                    $Stage_2->state_4,
                    $Stage_2->underway_4,
                    $Stage_2->info_1_4,
                    $Stage_2->info_2_4,
                    $Stage_2->uploading_1_4,
                    $Stage_2->enable_1_4,
                    $Stage_2->uploading_2_4,
                    $Stage_2->enable_2_4,
                    $Stage_2->uploading_3_4,
                    $Stage_2->enable_3_4,
                    $Stage_2->enableView_4
                );
                tableStage(
                    $Stage_2->stage_count_5,
                    $Stage_2->add_5,
                    $Stage_2->description_5,
                    $Stage_2->info_general_5,
                    $Stage_2->state_5,
                    $Stage_2->underway_5,
                    $Stage_2->info_1_5,
                    $Stage_2->info_2_5,
                    $Stage_2->uploading_1_5,
                    $Stage_2->enable_1_5,
                    $Stage_2->uploading_2_5,
                    $Stage_2->enable_2_5,
                    $Stage_2->uploading_3_5,
                    $Stage_2->enable_3_5,
                    $Stage_2->enableView_5
                );
                ?>
            </tbody>
            <thead class="table-light" data-bs-toggle="collapse" data-bs-target="#section3" aria-expanded="true" style="cursor: pointer;">
                <tr class="thead">
                    <th colspan="14">Fase 3 - Confirmación embarazo - Primer trimestre</th>
                </tr>
            </thead>
            <tbody id="section3" class="collapse show">
                <tr class="thead">
                    <?php
                    headerStage($Stage_3->titles);
                    ?>
                </tr>
                <?php
                tableStage2(
                    $Stage_3->stage_count_1,
                    $Stage_3->add_1,
                    $Stage_3->description_1,
                    $Stage_3->info_general_1,
                    $Stage_3->state_1,
                    $Stage_3->underway_1,
                    $Stage_3->info_1_1,
                    $Stage_3->uploading_1_1,
                    $Stage_3->enable_1_1,
                    $Stage_3->uploading_2_1,
                    $Stage_3->enable_2_1,
                    $Stage_3->uploading_3_1,
                    $Stage_3->enable_3_1,
                    $Stage_3->enableView_1
                );
                tableStage2(
                    $Stage_3->stage_count_2,
                    $Stage_3->add_2,
                    $Stage_3->description_2,
                    $Stage_3->info_general_2,
                    $Stage_3->state_2,
                    $Stage_3->underway_2,
                    $Stage_3->info_1_2,
                    $Stage_3->uploading_1_2,
                    $Stage_3->enable_1_2,
                    $Stage_3->uploading_2_2,
                    $Stage_3->enable_2_2,
                    $Stage_3->uploading_3_2,
                    $Stage_3->enable_3_2,
                    $Stage_3->enableView_2
                );
                tableStage2(
                    $Stage_3->stage_count_3,
                    $Stage_3->add_3,
                    $Stage_3->description_3,
                    $Stage_3->info_general_3,
                    $Stage_3->state_3,
                    $Stage_3->underway_3,
                    $Stage_3->info_1_3,
                    $Stage_3->uploading_1_3,
                    $Stage_3->enable_1_3,
                    $Stage_3->uploading_2_3,
                    $Stage_3->enable_2_3,
                    $Stage_3->uploading_3_3,
                    $Stage_3->enable_3_3,
                    $Stage_3->enableView_3
                );
                ?>
            </tbody>
            <thead class="table-light" data-bs-toggle="collapse" data-bs-target="#section4" aria-expanded="true" style="cursor: pointer;">
                <tr class="thead">
                    <th colspan="14">Fase 4 - Seguimiento del embarazo - Segundo Trimestre</th>
                </tr>
            </thead>
            <tbody id="section4" class="collapse show">
                <?php
                tableStage2(
                    $Stage_4->stage_count_1,
                    $Stage_4->add_1,
                    $Stage_4->description_1,
                    $Stage_4->info_general_1,
                    $Stage_4->state_1,
                    $Stage_4->underway_1,
                    $Stage_4->info_1_1,
                    $Stage_4->uploading_1_1,
                    $Stage_4->enable_1_1,
                    $Stage_4->uploading_2_1,
                    $Stage_4->enable_2_1,
                    $Stage_4->uploading_3_1,
                    $Stage_4->enable_3_1,
                    $Stage_4->enableView_1
                );
                tableStage2(
                    $Stage_4->stage_count_2,
                    $Stage_4->add_2,
                    $Stage_4->description_2,
                    $Stage_4->info_general_2,
                    $Stage_4->state_2,
                    $Stage_4->underway_2,
                    $Stage_4->info_1_2,
                    $Stage_4->uploading_1_2,
                    $Stage_4->enable_1_2,
                    $Stage_4->uploading_2_2,
                    $Stage_4->enable_2_2,
                    $Stage_4->uploading_3_2,
                    $Stage_4->enable_3_2,
                    $Stage_4->enableView_2
                );
                tableStage2(
                    $Stage_4->stage_count_3,
                    $Stage_4->add_3,
                    $Stage_4->description_3,
                    $Stage_4->info_general_3,
                    $Stage_4->state_3,
                    $Stage_4->underway_3,
                    $Stage_4->info_1_3,
                    $Stage_4->uploading_1_3,
                    $Stage_4->enable_1_3,
                    $Stage_4->uploading_2_3,
                    $Stage_4->enable_2_3,
                    $Stage_4->uploading_3_3,
                    $Stage_4->enable_3_3,
                    $Stage_4->enableView_3
                );
                tableStage2(
                    $Stage_4->stage_count_4,
                    $Stage_4->add_4,
                    $Stage_4->description_4,
                    $Stage_4->info_general_4,
                    $Stage_4->state_4,
                    $Stage_4->underway_4,
                    $Stage_4->info_1_4,
                    $Stage_4->uploading_1_4,
                    $Stage_4->enable_1_4,
                    $Stage_4->uploading_2_4,
                    $Stage_4->enable_2_4,
                    $Stage_4->uploading_3_4,
                    $Stage_4->enable_3_4,
                    $Stage_4->enableView_4
                );
                ?>
            </tbody>
            <thead class="table-light" data-bs-toggle="collapse" data-bs-target="#section5" aria-expanded="true" style="cursor: pointer;">
                <tr class="thead">
                    <th colspan="14">Fase 5 - Seguimiento del embarazo - Tercer Trimestre > Parto</th>
                </tr>
            </thead>
            <tbody id="section5" class="collapse show">
                <?php
                tableStage2(
                    $Stage_5->stage_count_1,
                    $Stage_5->add_1,
                    $Stage_5->description_1,
                    $Stage_5->info_general_1,
                    $Stage_5->state_1,
                    $Stage_5->underway_1,
                    $Stage_5->info_1_1,
                    $Stage_5->uploading_1_1,
                    $Stage_5->enable_1_1,
                    $Stage_5->uploading_2_1,
                    $Stage_5->enable_2_1,
                    $Stage_5->uploading_3_1,
                    $Stage_5->enable_3_1,
                    $Stage_5->enableView_1
                );
                tableStage2(
                    $Stage_5->stage_count_2,
                    $Stage_5->add_2,
                    $Stage_5->description_2,
                    $Stage_5->info_general_2,
                    $Stage_5->state_2,
                    $Stage_5->underway_2,
                    $Stage_5->info_1_2,
                    $Stage_5->uploading_1_2,
                    $Stage_5->enable_1_2,
                    $Stage_5->uploading_2_2,
                    $Stage_5->enable_2_2,
                    $Stage_5->uploading_3_2,
                    $Stage_5->enable_3_2,
                    $Stage_5->enableView_2
                );
                tableStage2(
                    $Stage_5->stage_count_3,
                    $Stage_5->add_3,
                    $Stage_5->description_3,
                    $Stage_5->info_general_3,
                    $Stage_5->state_3,
                    $Stage_5->underway_3,
                    $Stage_5->info_1_3,
                    $Stage_5->uploading_1_3,
                    $Stage_5->enable_1_3,
                    $Stage_5->uploading_2_3,
                    $Stage_5->enable_2_3,
                    $Stage_5->uploading_3_3,
                    $Stage_5->enable_3_3,
                    $Stage_5->enableView_3
                );
                tableStage2(
                    $Stage_5->stage_count_4,
                    $Stage_5->add_4,
                    $Stage_5->description_4,
                    $Stage_5->info_general_4,
                    $Stage_5->state_4,
                    $Stage_5->underway_4,
                    $Stage_5->info_1_4,
                    $Stage_5->uploading_1_4,
                    $Stage_5->enable_1_4,
                    $Stage_5->uploading_2_4,
                    $Stage_5->enable_2_4,
                    $Stage_5->uploading_3_4,
                    $Stage_5->enable_3_4,
                    $Stage_5->enableView_4
                );
                tableStage2(
                    $Stage_5->stage_count_5,
                    $Stage_5->add_5,
                    $Stage_5->description_5,
                    $Stage_5->info_general_5,
                    $Stage_5->state_5,
                    $Stage_5->underway_5,
                    $Stage_5->info_1_5,
                    $Stage_5->uploading_1_5,
                    $Stage_5->enable_1_5,
                    $Stage_5->uploading_2_5,
                    $Stage_5->enable_2_5,
                    $Stage_5->uploading_3_5,
                    $Stage_5->enable_3_5,
                    $Stage_5->enableView_5
                );
                tableStage2(
                    $Stage_5->stage_count_6,
                    $Stage_5->add_6,
                    $Stage_5->description_6,
                    $Stage_5->info_general_6,
                    $Stage_5->state_6,
                    $Stage_5->underway_6,
                    $Stage_5->info_1_6,
                    $Stage_5->uploading_1_6,
                    $Stage_5->enable_1_6,
                    $Stage_5->uploading_2_6,
                    $Stage_5->enable_2_6,
                    $Stage_5->uploading_3_6,
                    $Stage_5->enable_3_6,
                    $Stage_5->enableView_6
                );
                tableStage2(
                    $Stage_5->stage_count_7,
                    $Stage_5->add_7,
                    $Stage_5->description_7,
                    $Stage_5->info_general_7,
                    $Stage_5->state_7,
                    $Stage_5->underway_7,
                    $Stage_5->info_1_7,
                    $Stage_5->uploading_1_7,
                    $Stage_5->enable_1_7,
                    $Stage_5->uploading_2_7,
                    $Stage_5->enable_2_7,
                    $Stage_5->uploading_3_7,
                    $Stage_5->enable_3_7,
                    $Stage_5->enableView_7
                );
                tableStage2(
                    $Stage_5->stage_count_8,
                    $Stage_5->add_8,
                    $Stage_5->description_8,
                    $Stage_5->info_general_8,
                    $Stage_5->state_8,
                    $Stage_5->underway_8,
                    $Stage_5->info_1_8,
                    $Stage_5->uploading_1_8,
                    $Stage_5->enable_1_8,
                    $Stage_5->uploading_2_8,
                    $Stage_5->enable_2_8,
                    $Stage_5->uploading_3_8,
                    $Stage_5->enable_3_8,
                    $Stage_5->enableView_8
                );
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <!-- Favicon -->
    <script src="https://kit.fontawesome.com/b8332e4c7c.js" crossorigin="anonymous"></script>
    <!-- Animation -->
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

        function fetchContent(id, newValue, stage, row, row_max) {
            fetch('ipsRegisterBack.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        content: newValue,
                        stage: stage,
                        row: row,
                        row_max: row_max
                    })
                })
                .then(res => res.text()) // expect plain text for echo
                .then(data => {
                    console.log('Server responded with:', data);
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</main>