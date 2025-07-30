<?php

require_once '../../../../vendor/autoload.php';
// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();

// Set full-page background image using CSS
$backgroundImage1 = 'images/travelMedicalCare.jpg'; // Absolute or relative path

if (isset($_POST['tmc'])) {
    $tmc = 'unset';
} else {
    $tmc = $_POST['tmc'];
}

$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage1')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6); // 6 = stretch to fill
$html = '
<style>
    body {
        font-family: sans-serif;
    }
</style>
<p style="color: black; font-size: 25px; padding-top: -23px; padding-left: 170px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="color: black; font-size: 18px; padding-top: -30px; padding-left: 124px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="color: black; font-size: 15px; padding-top: 88px; padding-left: 13px; font-weight: bold;">' . $_POST['date'] . '</p>
<p style="color: black; font-size: 15px; text-align: right; padding-top: -15px; padding-right: -8px; font-weight: bold;">' . $_POST['balance'] . '</p>
<p style="color: black; font-size: 15px; text-align: right; padding-top: -37px; padding-right: 178px; font-weight: bold;">' . $_POST['balance'] . '</p>';

if (isset($_POST['description1']) || isset($_POST['description2']) || isset($_POST['description3'])) {
    $html .= '<div width="510px" height="10px" style="margin-top: 60px;"></div>';
}

if (isset($_POST['description1'])) {
    $html .= 
    '<table width="510px" style="margin-left: 210px; margin-top: 15px;">
        <tr>
            <td width="40%" style="padding-right: 20px; padding-left: 10px;">' . $_POST['description1'] . '</td>
            <td width="20%" style="text-align: center;">' . $_POST['qty1'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price1'] . '</td>
            <td width="10%">' . $_POST['total1'] . '</td>
        </tr>
    </table>';
}

if (isset($_POST['description2'])) {
    $html .= 
    '<table width="510px" style="margin-left: 210px; margin-top: 15px;">
        <tr>
            <td width="40%" style="padding-right: 20px; padding-left: 10px;">' . $_POST['description2'] . '</td>
            <td width="20%" style="text-align: center;">' . $_POST['qty2'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price2'] . '</td>
            <td width="10%">' . $_POST['total2'] . '</td>
        </tr>
    </table>';
}

if (isset($_POST['description3'])) {
    $html .= 
    '<table width="510px" style="margin-left: 210px; margin-top: 15px;">
        <tr>
            <td width="40%" style="padding-right: 20px; padding-left: 10px;">' . $_POST['description3'] . '</td>
            <td width="20%" style="text-align: center;">' . $_POST['qty3'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price3'] . '</td>
            <td width="10%">' . $_POST['total3'] . '</td>
        </tr>
    </table>';
}

$html .= '
<p style="position: absolute; font-size: 12px; top: 202mm; left: 185mm;" />' . $_POST['subtotal'] . '</p>
<p style="position: absolute; font-size: 12px; top: 211mm; left: 185mm;" />' . $_POST['tax'] . '</p>
<p style="position: absolute; font-size: 12px; top: 220mm; left: 185mm;" />' . $_POST['total'] . '</p>
';

$mpdf->WriteHTML($html);

$mpdf->Output();