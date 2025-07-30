<?php

require_once '../../../../vendor/autoload.php';
// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();

$uploadDir = 'uploads/';

$filename = basename($_FILES['image-1']['name']);
$targetFilePath1 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-1']['tmp_name'], $targetFilePath1);

$filename = basename($_FILES['image-2']['name']);
$targetFilePath2 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-2']['tmp_name'], $targetFilePath2);

$filename = basename($_FILES['image-3']['name']);
$targetFilePath3 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-3']['tmp_name'], $targetFilePath3);

$filename = basename($_FILES['image-4']['name']);
$targetFilePath4 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-4']['tmp_name'], $targetFilePath4);

$filename = basename($_FILES['image-5']['name']);
$targetFilePath5 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-5']['tmp_name'], $targetFilePath5);

$filename = basename($_FILES['image-6']['name']);
$targetFilePath6 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-6']['tmp_name'], $targetFilePath6);

$filename = basename($_FILES['image-7']['name']);
$targetFilePath7 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-7']['tmp_name'], $targetFilePath7);

$filename = basename($_FILES['image-8']['name']);
$targetFilePath8 = $uploadDir . $filename;
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
move_uploaded_file($_FILES['image-8']['tmp_name'], $targetFilePath8);

// Set full-page background image using CSS
$backgroundImage1 = 'images/medicalReport-1.jpg'; // Absolute or relative path
$backgroundImage2 = 'images/medicalReport-2.jpg'; // Absolute or relative path
$backgroundImage3 = 'images/medicalReport-3.jpg'; // Absolute or relative path

$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage1')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6); // 6 = stretch to fill
$html = '
<p style="color: black; font-size: 15px; padding-top: 83px; padding-left: 90px;">' . $_POST['date'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 450px;">' . $_POST['doctor'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 15px; padding-left: 195px;">' . $_POST['name'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 470px;">' . $_POST['age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 15px; padding-left: 275px;">' . $_POST['date-menst'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 560px;">' . $_POST['gest-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 150px; padding-left: 355px; width: 50px; text-align: center;">' . $_POST['diameter'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 550px; width: 50px; text-align: center;">' . $_POST['diameter-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 355px; width: 50px; text-align: center;">' . $_POST['circumference'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 550px; width: 50px; text-align: center;">' . $_POST['circumference-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 355px; width: 50px; text-align: center;">' . $_POST['circumference-abdm'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 550px; width: 50px; text-align: center;">' . $_POST['circumference-abdm-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 355px; width: 50px; text-align: center;">' . $_POST['length'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -37px; padding-left: 550px; width: 50px; text-align: center;">' . $_POST['length-age'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 425px; width: 150px; text-align: center;">' . $_POST['fetometry'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 425px; width: 150px; text-align: center;">' . $_POST['fetal-weight'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 425px; width: 150px; text-align: center;">' . $_POST['perc-weight'] . '</p>
<p style="color: black; font-size: 15px; padding-top: -12px; padding-left: 425px; width: 150px; text-align: center;">' . $_POST['cardiac-frec'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 80px; padding-left: -5px;">' . $_POST['comments'] . '</p>
';
$mpdf->WriteHTML($html);
$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage2')");
$mpdf->AddPage();
$html = '
<p style="color: black; font-size: 15px; padding-top: 200px; padding-left: 15px;">' . $_POST['diagnosis'] . '</p>
<img src="' . $targetFilePath1 . '" style="width: 300px; padding-left: 15px;" />
<img src="' . $targetFilePath2 . '" style="width: 300px; padding-left: 15px;" />
<img src="' . $targetFilePath3 . '" style="width: 300px; padding-left: 15px; padding-top: 10px;" />
<img src="' . $targetFilePath4 . '" style="width: 300px; padding-left: 15px;" />
';
$mpdf->WriteHTML($html);
$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage3')");
$mpdf->AddPage();
$html = '
<img src="' . $targetFilePath5 . '" style="width: 300px; padding-left: 15px; padding-top: 150px;" />
<img src="' . $targetFilePath6 . '" style="width: 300px; padding-left: 15px;" />
<img src="' . $targetFilePath7 . '" style="width: 300px; padding-left: 15px; padding-top: 10px;" />
<img src="' . $targetFilePath8 . '" style="width: 300px; padding-left: 15px;" />
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