<?php
include '../../../../includes/templates/validatePost.php';
require_once '../../../../vendor/autoload.php';
// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();

$uploadDir = 'uploads/';

$filename = basename($_FILES['image-1']['name']);
if ($filename !== '') {
$targetFilePath1 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-1']['tmp_name'], $targetFilePath1);
} else {
    $targetFilePath1 = 'white.jpg';
}

$filename = basename($_FILES['image-2']['name']);
if ($filename !== '') {
$targetFilePath2 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-2']['tmp_name'], $targetFilePath2);
} else {
    $targetFilePath2 = 'white.jpg';
}

$filename = basename($_FILES['image-3']['name']);
if ($filename !== '') {
$targetFilePath3 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-3']['tmp_name'], $targetFilePath3);
} else {
    $targetFilePath3 = 'white.jpg';
}

$filename = basename($_FILES['image-4']['name']);
if ($filename !== '') {
$targetFilePath4 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-4']['tmp_name'], $targetFilePath4);
} else {
    $targetFilePath4 = 'white.jpg';
}

$filename = basename($_FILES['image-5']['name']);
if ($filename !== '') {
$targetFilePath5 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-5']['tmp_name'], $targetFilePath5);
} else {
    $targetFilePath5 = 'white.jpg';
}

$filename = basename($_FILES['image-6']['name']);
if ($filename !== '') {
$targetFilePath6 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-6']['tmp_name'], $targetFilePath6);
} else {
    $targetFilePath6 = 'white.jpg';
}

$filename = basename($_FILES['image-7']['name']);
if ($filename !== '') {
$targetFilePath7 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-7']['tmp_name'], $targetFilePath7);
} else {
    $targetFilePath7 = 'white.jpg';
}

$filename = basename($_FILES['image-8']['name']);
if ($filename !== '') {
$targetFilePath8 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-8']['tmp_name'], $targetFilePath8);
} else {
    $targetFilePath8 = 'white.jpg';
}

// Set full-page background image using CSS
$backgroundImage1 = 'images/medicalReport-1.jpg'; // Absolute or relative path
$backgroundImage2 = 'images/medicalReport-2.jpg'; // Absolute or relative path
$backgroundImage3 = 'images/medicalReport-3.jpg'; // Absolute or relative path

$dateString = $_POST['date'];
$dateTime = DateTime::createFromFormat('Y-m-d', $dateString);
$newDateString = $dateTime->format('d-m-Y');

$dateString_menst = $_POST['date-menst'];
$dateTime_menst = DateTime::createFromFormat('Y-m-d', $dateString_menst);
$newDateString_menst = $dateTime_menst->format('d-m-Y');

$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage1')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6); // 6 = stretch to fill
$html = '
<p style="color: black; font-size: 15px; padding-top: 130px; padding-left: -10px;">' . $newDateString . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 460px;">' . $_POST['doctor'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 24px; padding-left: -10px;">' . $_POST['name'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 460px;">' . $_POST['age'] . ' años</p>
<p style="color: black; font-size: 15px; padding-top: 24px; padding-left: -10px;">' . $newDateString_menst . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 460px;">' . $_POST['gest-age'] . ' SDG</p>
<p style="color: black; font-size: 15px; padding-top: 102px; padding-left: 305px; width: 50px; text-align: center;">' . $_POST['diameter'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 565px; width: 50px; text-align: center;">' . $_POST['diameter-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 305px; width: 50px; text-align: center;">' . $_POST['circumference'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 565px; width: 50px; text-align: center;">' . $_POST['circumference-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 305px; width: 50px; text-align: center;">' . $_POST['circumference-abdm'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 565px; width: 50px; text-align: center;">' . $_POST['circumference-abdm-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 305px; width: 50px; text-align: center;">' . $_POST['length'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 565px; width: 50px; text-align: center;">' . $_POST['length-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 35px; padding-left: 255px; width: 150px; text-align: center;">' . $_POST['fetometry'] . ' SDG</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 255px; width: 150px; text-align: center;">' . $_POST['fetal-weight'] . ' GRS</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 255px; width: 150px; text-align: center;">' . $_POST['perc-weight'] . ' %</p>
<p style="color: black; font-size: 15px; padding-top: -5px; padding-left: 255px; width: 150px; text-align: center;">' . $_POST['cardiac-frec'] . ' LPM</p>
<p style="color: black; font-size: 15px; padding-top: 80px; padding-left: -5px;">' . $_POST['comments'] . '</p>
';
$mpdf->WriteHTML($html);
$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage2')");
$mpdf->AddPage();
$html = '
<p style="color: black; font-size: 15px; padding-top: 115px; padding-left: -5px;">' . $_POST['diagnosis'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 150px;"> </p>
<img src="' . $targetFilePath1 . '" style="width: 300px; height: 200px; padding-top: 15px; padding-left: 15px;" />
<img src="' . $targetFilePath2 . '" style="width: 300px; height: 200px; padding-left: 15px;" />
<img src="' . $targetFilePath3 . '" style="width: 300px; height: 200px; padding-left: 15px; padding-top: 10px;" />
<img src="' . $targetFilePath4 . '" style="width: 300px; height: 200px; padding-left: 15px;" />
';
$mpdf->WriteHTML($html);
$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage3')");
$mpdf->AddPage();
$html = '
<img src="' . $targetFilePath5 . '" style="width: 300px; height: 200px; padding-left: 15px; padding-top: 150px;" />
<img src="' . $targetFilePath6 . '" style="width: 300px; height: 200px; padding-left: 15px;" />
<img src="' . $targetFilePath7 . '" style="width: 300px; height: 200px; padding-left: 15px; padding-top: 10px;" />
<img src="' . $targetFilePath8 . '" style="width: 300px; height: 200px; padding-left: 15px;" />
';
$mpdf->WriteHTML($html);

$imagePattern = '*.{jpg,jpeg,png,gif}'; // Matches common image extensions

$imageFiles = glob($uploadDir . $imagePattern, GLOB_BRACE);

if ($imageFiles !== false) {
    foreach ($imageFiles as $file) {
        if (is_file($file)) {
            if (unlink($file)) {
                echo "Deleted: " . $file . "<br>";
            } else {
                echo "Failed to delete: " . $file . "<br>";
            }
        }
    }
} else {
    echo "Error: Could not retrieve image files from the specified folder.<br>";
}

$mpdf->Output();