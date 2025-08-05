<?php

require_once '../../../../vendor/autoload.php';
// Create an instance of mPDF
$mpdf = new \Mpdf\Mpdf();

if ($_POST['currency'] === 'euro') {
    $backgroundImage1 = 'images/BabyMedic_euro.jpg'; // Euro background
} else {
    $backgroundImage1 = 'images/BabyMedic_dollar.jpg'; // Dollar background
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

// Set the locale to French
$formatter = new IntlDateFormatter(
    'fr_FR',                      // Locale
    IntlDateFormatter::LONG,     // Date format
    IntlDateFormatter::NONE      // Time format
);
$frenchDate = $formatter->format($dateTime); // Output: 5 août 2025

if ($_POST['currency'] === 'euro') {
    $html = '
<style>
    body {
        font-family: sans-serif;
    }
</style>
<p style="position: absolute; font-size: 25px; top: 10mm; left: 184mm; width: 70px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="position: absolute; font-size: 17px; top: 19mm; left: 150mm; width: 200px; font-weight: bold; text-align: center;">' . $frenchDate . '</p>
<p style="position: absolute; font-size: 15px; top: 64mm; right: 20mm; width: 70px; font-weight: bold; text-align: right;">' . $_POST['balance'] . ' € </p>
<p style="position: absolute; font-size: 15px; top: 64mm; left: 14.5mm; width: 300px;">' . $_POST['country'] . '</p>
<p style="position: absolute; font-size: 15px; top: 57mm; left: 14.5mm; width: 300px;">' . $_POST['bill'] . '</p>';

    if (isset($_POST['description1']) || isset($_POST['description2']) || isset($_POST['description3']) || isset($_POST['description4'])) {
        $html .= '<div width="510px" height="295px" style="margin-top: 60px;"></div>';
    }

    if (isset($_POST['description1'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 15px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description1'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty1'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price1'] . ' €</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total1'] . ' €</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description2'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description2'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty2'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price2'] . ' €</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total2'] . ' €</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description3'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description3'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty3'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price3'] . ' €</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total3'] . ' €</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description4'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description4'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty4'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price4'] . ' €</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total4'] . ' €</td>
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
<p style="position: absolute; font-size: 25px; top: 10mm; left: 184mm; width: 70px; font-weight: bold;">' . $_POST['tmc'] . '</p>
<p style="position: absolute; font-size: 17px; top: 19mm; left: 150mm; width: 200px; font-weight: bold; text-align: center;">' . $frenchDate . '</p>
<p style="position: absolute; font-size: 15px; top: 64mm; right: 20mm; width: 70px; font-weight: bold; text-align: right;">' . $_POST['balance'] . ' $ </p>
<p style="position: absolute; font-size: 15px; top: 64mm; left: 14.5mm; width: 300px;">' . $_POST['country'] . '</p>
<p style="position: absolute; font-size: 15px; top: 57mm; left: 14.5mm; width: 300px;">' . $_POST['bill'] . '</p>';

    if (isset($_POST['description1']) || isset($_POST['description2']) || isset($_POST['description3']) || isset($_POST['description4'])) {
        $html .= '<div width="510px" height="295px" style="margin-top: 60px;"></div>';
    }

    if (isset($_POST['description1'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 15px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description1'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty1'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price1'] . ' $</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total1'] . ' $</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description2'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description2'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty2'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price2'] . ' $</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total2'] . ' $</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description3'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description3'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty3'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price3'] . ' $</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total3'] . ' $</td>
        </tr>
    </table>';
    }

    if (isset($_POST['description4'])) {
        $html .=
            '<table width="680px" style="margin-left: -10px; margin-top: 35px;">
        <tr>
            <td width="34%" style="padding-left: 10px;">' . $_POST['description4'] . '</td>
            <td width="27%" style="padding-left: 50px; text-align: center;">' . $_POST['qty4'] . '</td>
            <td width="30%" style="text-align: center;">' . $_POST['price4'] . ' $</td>
            <td width="9%" style="text-align: center   ;">' . $_POST['total4'] . ' $</td>
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
