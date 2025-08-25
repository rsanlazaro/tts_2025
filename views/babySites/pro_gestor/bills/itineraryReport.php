<?php
include '../../../../includes/templates/validatePost.php';
require_once '../../../../vendor/autoload.php';
$period = ucfirst($_POST['period']);
$name = ucfirst($_POST['name']);
$date_1 = ucfirst($_POST['date_1']);
$date_2 = ucfirst($_POST['date_2']);
$date_3 = ucfirst($_POST['date_3']);
$date_4 = ucfirst($_POST['date_4']);
$date_5 = ucfirst($_POST['date_5']);
$date_6 = ucfirst($_POST['date_6']);
if ($date_1 == '') {
    $date_1 = 'Jour 1';
}
if ($date_2 == '') {
    $date_2 = 'Jour 2';
}
if ($date_3 == '') {
    $date_3 = 'Jour 3';
}
if ($date_4 == '') {
    $date_4 = 'Jour 4';
}
if ($date_5 == '') {
    $date_5 = 'Jour 5';
}
if ($date_6 == '') {
    $date_6 = 'Jour 6';
}

$activity_1_1 = ucfirst($_POST['activity_1_1']);
$activity_1_2 = ucfirst($_POST['activity_1_2']);
$activity_1_3 = ucfirst($_POST['activity_1_3']);
$activity_1_4 = ucfirst($_POST['activity_1_4']);
$activity_2_1 = ucfirst($_POST['activity_2_1']);
$activity_2_2 = ucfirst($_POST['activity_2_2']);
$activity_2_3 = ucfirst($_POST['activity_2_3']);
$activity_2_4 = ucfirst($_POST['activity_2_4']);
$activity_3_1 = ucfirst($_POST['activity_3_1']);
$activity_3_2 = ucfirst($_POST['activity_3_2']);
$activity_3_3 = ucfirst($_POST['activity_3_3']);
$activity_3_4 = ucfirst($_POST['activity_3_4']);
$activity_4_1 = ucfirst($_POST['activity_4_1']);
$activity_4_2 = ucfirst($_POST['activity_4_2']);
$activity_4_3 = ucfirst($_POST['activity_4_3']);
$activity_4_4 = ucfirst($_POST['activity_4_4']);
$activity_5_1 = ucfirst($_POST['activity_5_1']);
$activity_5_2 = ucfirst($_POST['activity_5_2']);
$activity_5_3 = ucfirst($_POST['activity_5_3']);
$activity_5_4 = ucfirst($_POST['activity_5_4']);
$activity_6_1 = ucfirst($_POST['activity_6_1']);
$activity_6_2 = ucfirst($_POST['activity_6_2']);
$activity_6_3 = ucfirst($_POST['activity_6_3']);
$activity_6_4 = ucfirst($_POST['activity_6_4']);

$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

/* Configuracion */
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '../../../../../custom/font/directory',
    ]),
    'fontdata' => $fontData + [ // lowercase letters only in font key
        'poppins_black' => [
            'R' => 'Poppins-Bold.ttf'
        ],
        'poppins' => [
            'R' => 'Poppins-Medium.ttf'
        ]
    ],
    'default_font' => 'poppins'
]);

$activity_1 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_1 = $activity_1 . '<p>' . ${'activity_1_' . $x} . '</p>';
}

$activity_2 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_2 = $activity_2 . '<p>' . ${'activity_2_' . $x} . '</p>';
}

$activity_3 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_3 = $activity_3 . '<p>' . ${'activity_3_' . $x} . '</p>';
}

$activity_4 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_4 = $activity_4 . '<p>' . ${'activity_4_' . $x} . '</p>';
}

$activity_5 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_5 = $activity_5 . '<p>' . ${'activity_5_' . $x} . '</p>';
}

$activity_6 = '';

for ($x = 1; $x <= 4; $x++) {
    $activity_6 = $activity_6 . '<p>' . ${'activity_6_' . $x} . '</p>';
}

$data = '';
$data .= '
<style>
    @page {
        margin: 0px;
        padding: 0px;  
        sheet-size: 250mm 324mm;
    }
    .header-one {
        background-color: #fa5995;
        border-radius: 0 50px 50px 0;
        font-size: 20px;
        line-height: 0.5;
    }
    .header-one p,
    .header-two p {
        font-family: poppins;
        color: white;
        font-weight: bold;
    }
    .header-one p {
        text-align: center;
    }
    .header-two p {
        text-align: right;
        margin-right: 100px;
    }
    .header-two {
        background-color: #fa5995;
        border-radius: 50px 0 0 50px;
        font-size: 20px;
        line-height: 0.5;
        margin-top: -107px;
        padding-bottom: 1px;
    }
    .logo {
        position: absolute;
        top: 10px;
        right: 0;
        width: 100px;
        height: auto;
    }
    .line {
        width: 250px;
        height: 1px; /* Adjust thickness */
        background-color: red;
        margin: 0 auto;
        position: absolute;
        border-top: 1px solid red;
        top: -100px;
    }
    .bottom-info {
        background-color: #fa5995;
        margin-top: 42px;
        padding-top: 50px;
        padding-bottom: 40px;
        padding-right: 40px;
        padding-left: 40px;
    }
    .square-1 {
        background-color: #7d99bf;
        border-radius: 30px;
        width: 90%;
        margin: auto;
        text-align: center;
        padding-top: 10px;
        color: white;
        margin-bottom: 40px;
        font-size: 18px;
        line-height: 1;
        height: 50px;
    }
    .square-2 {
        background-color: white;
        width: 100%;
        color: black;
        border-radius: 30px;
        text-align: left;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 30px;
        font-size: 15px;
        margin-top: 10px;
        height: 182px;
        line-height: 1.25;
    }

</style>';
$data2 = '
<div style="padding-top: 25px;">
    <div style="width: 100%;">
    <div class="header-one" align="left" style="width: 60%;float: left;">
        <p class="first-p">' . $period . '</p>
        <p class="second-p">Nom(s): ' . $name . '</p>
    </div>

    <div align="right">
        <img src="logo.png" style="max-width:300px; height:auto; margin-right: 50px; margin-top: 25px;"/>
    </div>
    </div>
</div>
<div style="padding-top: 25px;">
    <div style="width: 100%;">
    <div align="left">
        <img src="baby.png" style="max-height:125px; height:auto; margin-left: 50px;"/>
    </div>
    <div class="header-two" align="right" style="width: 90%;float: right;">
        <p class="first-p">Bienvenue chez Babyboom. Nous sommes ravis de vous présenter</p>
        <p class="second-p">l\'itinéraire de votre séjour à México</p>
    </div>

    </div>
</div>
<div class="bottom-info">
    <div style="width: 100%;">
        <div class="square" align="left" style="width: 50%;float: left;">
            <div class="square-1 square-left">
                ' . $date_1 . '
                <div class="square-2">
                    ' . $activity_1 . '
                </div>
            </div>
        </div>

        <div class="square" align="right" style="width: 50%;float: right;">
            <div class="square-1 square-right">
                ' . $date_2 . '
                <div class="square-2">
                    ' . $activity_2 . '
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%;">
        <div class="square" align="left" style="width: 50%;float: left;">
            <div class="square-1 square-left">
                ' . $date_3 . '
                <div class="square-2">
                    ' . $activity_3 . '
                </div>
            </div>
        </div>

        <div class="square" align="right" style="width: 50%;float: right;">
            <div class="square-1 square-right">
                ' . $date_4 . '
                <div class="square-2">
                    ' . $activity_4 . '
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%;">
        <div class="square" align="left" style="width: 50%;float: left;">
            <div class="square-1 square-left">
                ' . $date_5 . '
                <div class="square-2">
                    ' . $activity_5 . '
                </div>
            </div>
        </div>

        <div class="square" align="right" style="width: 50%;float: right;">
            <div class="square-1 square-right">
                ' . $date_6 . '
                <div class="square-2">
                    ' . $activity_6 . '
                </div>
            </div>
        </div>
    </div>
</div>
';
$data2 = $data2 . '
<div>
    <img src="2.jpg" style="width:100%; height:auto;">
    <img src="3.jpg" style="width:100%; height:auto;">
    <img src="4.jpg" style="width:100%; height:auto;">
    <img src="5.jpg" style="width:100%; height:auto;">
    <img src="6.jpg" style="width:100%; height:auto;">
    <img src="7.jpg" style="width:100%; height:auto;">
    <img src="8.jpg" style="width:100%; height:auto;">
    <img src="9.jpg" style="width:100%; height:auto;">
    <img src="10.jpg" style="width:100%; height:auto;">
    <img src="11.jpg" style="width:100%; height:auto;">
    <img src="12.jpg" style="width:100%; height:auto;">
    <img src="13.jpg" style="width:100%; height:auto;">
    <img src="14.jpg" style="width:100%; height:auto;">
</div>';

$mpdf->WriteHTML($data);
$mpdf->WriteHTML($data2);
$mpdf->Output();