<?php

require_once '../../../../vendor/autoload.php';
// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();

if ($_POST['currency'] === 'euro') {
    $backgroundImage1 = 'images/NexaTravel_euro.jpg'; // Euro background
} else {
    $backgroundImage1 = 'images/NexaTravel_dollar.jpg'; // Dollar background
}

if (isset($_POST['tmc'])) {
    $tmc = 'unset';
} else {
    $tmc = $_POST['tmc'];
}

$mpdf->SetDefaultBodyCSS('background', "url('$backgroundImage1')");
$mpdf->SetDefaultBodyCSS('background-image-resize', 6); // 6 = stretch to fill

$dateString = $_POST['date'];
$dateTime = DateTime::createFromFormat('Y-m-d', $dateString);
$day = $dateTime->format('d');
$year = $dateTime->format('Y');
$month = $dateTime->format('m');

$frenchMonths = [
    '01' => 'janvier',
    '02' => 'février',
    '03' => 'mars',
    '04' => 'avril',
    '05' => 'mai',
    '06' => 'juin',
    '07' => 'juillet',
    '08' => 'août',
    '09' => 'septembre',
    '10' => 'octobre',
    '11' => 'novembre',
    '12' => 'décembre'
];
$frenchDate = $day . ' ' . $frenchMonths[$month] . ' ' . $year; // Output: 5 août 2025

if ($_POST['currency'] === 'euro') {
    $html = '
<style>
    body {
        font-family: sans-serif;
    }
</style>
<p style="position: absolute; font-size: 25px; top: 11mm; left: 186mm; width: 70px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="position: absolute; font-size: 17px; top: 20mm; left: 150mm; width: 200px; font-weight: bold; text-align: center;">' . $frenchDate . '</p>
<p style="position: absolute; font-size: 15px; top: 64mm; right: 20mm; width: 70px; font-weight: bold; text-align: right;">' . $_POST['balance'] . ' € </p>
<p style="position: absolute; font-size: 15px; top: 64mm; left: 14.5mm; width: 300px;">' . $_POST['country'] . '</p>
<p style="position: absolute; font-size: 15px; top: 57mm; left: 14.5mm; width: 300px;">' . $_POST['bill'] . '</p>';

($_POST['price1'] !== '') ? $price_1 = $_POST['price1'] . ' €' : $price_1 = '';
($_POST['price2'] !== '') ? $price_2 = $_POST['price2'] . ' €' : $price_2 = '';
($_POST['price3'] !== '') ? $price_3 = $_POST['price3'] . ' €' : $price_3 = '';
($_POST['price4'] !== '') ? $price_4 = $_POST['price4'] . ' €' : $price_4 = '';

($_POST['total1'] !== '') ? $total_1 = $_POST['total1'] . ' €' : $total_1 = '';
($_POST['total2'] !== '') ? $total_2 = $_POST['total2'] . ' €' : $total_2 = '';
($_POST['total3'] !== '') ? $total_3 = $_POST['total3'] . ' €' : $total_3 = '';
($_POST['total4'] !== '') ? $total_4 = $_POST['total4'] . ' €' : $total_4 = '';

    if (isset($_POST['description1']) || isset($_POST['description2']) || isset($_POST['description3']) || isset($_POST['description4'])) {
        $html .= '<div width="510px" height="295px" style="margin-top: 60px;"></div>';
    }

    if (isset($_POST['description1'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 15px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description1'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty1'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_1 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_1 . ' </td>
        </tr>
    </table>';
    }

    if (isset($_POST['description2'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description2'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty2'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_2 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_2 . ' </td>
        </tr>
    </table>';
    }

    if (isset($_POST['description3'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description3'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty3'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_3 . '</td>
            <td width="9%" style="text-align: center   ;">' . $total_3 . '</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description4'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description4'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty4'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_4 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_4 . ' </td>
        </tr>
    </table>';
    }

    $html .= '
<p style="position: absolute; font-size: 15px; top: 156mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['subtotal'] . ' €</p>
<p style="position: absolute; font-size: 15px; top: 168mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['tax'] . ' €</p>
<p style="position: absolute; font-size: 15px; top: 179mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['total'] . ' €</p>
';
} else {
        $html = '
<style>
    body {
        font-family: sans-serif;
    }
</style>
<p style="position: absolute; font-size: 25px; top: 11mm; left: 187mm; width: 70px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="position: absolute; font-size: 17px; top: 20mm; left: 150mm; width: 200px; font-weight: bold; text-align: center;">' . $frenchDate . '</p>
<p style="position: absolute; font-size: 15px; top: 64mm; right: 20mm; width: 70px; font-weight: bold; text-align: right;">' . $_POST['balance'] . ' $ </p>
<p style="position: absolute; font-size: 15px; top: 64mm; left: 14.5mm; width: 300px;">' . $_POST['country'] . '</p>
<p style="position: absolute; font-size: 15px; top: 57mm; left: 14.5mm; width: 300px;">' . $_POST['bill'] . '</p>';

($_POST['price1'] !== '') ? $price_1 = $_POST['price1'] . ' $' : $price_1 = '';
($_POST['price2'] !== '') ? $price_2 = $_POST['price2'] . ' $' : $price_2 = '';
($_POST['price3'] !== '') ? $price_3 = $_POST['price3'] . ' $' : $price_3 = '';
($_POST['price4'] !== '') ? $price_4 = $_POST['price4'] . ' $' : $price_4 = '';

($_POST['total1'] !== '') ? $total_1 = $_POST['total1'] . ' $' : $total_1 = '';
($_POST['total2'] !== '') ? $total_2 = $_POST['total2'] . ' $' : $total_2 = '';
($_POST['total3'] !== '') ? $total_3 = $_POST['total3'] . ' $' : $total_3 = '';
($_POST['total4'] !== '') ? $total_4 = $_POST['total4'] . ' $' : $total_4 = '';

    if (isset($_POST['description1']) || isset($_POST['description2']) || isset($_POST['description3']) || isset($_POST['description4'])) {
        $html .= '<div width="510px" height="295px" style="margin-top: 60px;"></div>';
    }

    if (isset($_POST['description1'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 15px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description1'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty1'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_1 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_1 . ' </td>
        </tr>
    </table>';
    }

    if (isset($_POST['description2'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description2'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty2'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_2 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_2 . ' </td>
        </tr>
    </table>';
    }

    if (isset($_POST['description3'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description3'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty3'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_3 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_3 . ' </td>
        </tr>
    </table>';
    }

    if (isset($_POST['description4'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description4'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty4'] . '</td>
            <td width="30%" style="text-align: center;">' . $price_4 . ' </td>
            <td width="9%" style="text-align: center   ;">' . $total_4 . ' </td>
        </tr>
    </table>';
    }

    $html .= '
<p style="position: absolute; font-size: 15px; top: 156mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['subtotal'] . ' $</p>
<p style="position: absolute; font-size: 15px; top: 168mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['tax'] . ' $</p>
<p style="position: absolute; font-size: 15px; top: 179mm; right: 15mm; width: 100px; text-align: right;" />' . $_POST['total'] . ' $</p>
';
}

$mpdf->WriteHTML($html);

$mpdf->Output();
