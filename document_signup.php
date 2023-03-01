<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;

if ($user == null) {
    header('location: ' . $host_path . '/login.php');
}
if ($user["ur_Id"] == "R001") {
    header('location: ' . $host_path . '/noaccess.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        :root {
            --bleeding: 0.5cm;
            --margin: 1cm;
        }

        @page {
            size: A4;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0 auto;
            padding: 0;
            background: rgb(204, 204, 204);
            display: flex;
            flex-direction: column;
        }

        .page {
            display: inline-block;
            position: relative;
            height: 297mm;
            width: 210mm;
            font-size: 12pt;
            margin: 2em auto;
            padding: calc(var(--bleeding) + var(--margin));
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            background: white;
        }

        @media screen {
            .page::after {
                position: absolute;
                content: '';
                top: 0;
                left: 0;
                width: calc(100% - var(--bleeding) * 2);
                height: calc(100% - var(--bleeding) * 2);
                margin: var(--bleeding);
                outline: thin dashed black;
                pointer-events: none;
                z-index: 9999;
            }
        }

        @media print {
            .page {
                margin: 0;
                overflow: hidden;
            }
        }
    </style>
    <title>Document</title>
</head>

<body>
    <div class="page">
        <!-- Your content here -->
        <table style="width:100%;text-align: center;">
            <tr>
                <td></td>
                <td><img src="<?= $host_path ?>/src/img/Seal_of_Khon_Kaen.png" height="110px"></img></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>โซน ................... </td>
                <td rowspan="3" style="position: absolute;border: 1px solid red;top: 160px; right: 80px;"><img src="<?= $host_path ?>/src/img/Seal_of_Khon_Kaen.png" height="150px" width="150px"></img></td>
            </tr>
            <tr>
                <td ></td>
                <td>ประวัติผู้ประกอบการถนนคนเดินขอนแก่น
                <br>เทศบาลขอนแก่น </td>
                <td></td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td>รหัส Walk in : ..............................................</td>
            </tr>
            <tr>
                <td>ชื่อ-สกุล : .............................................................................................</td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td>Name-Sumane</td>
            </tr>
            <tr>
                <td>วัน เดือน ปีเกิด ..................................</td>
                <td>อายุ......................ปี</td>
            </tr>
            <tr>
                <td>Date of brith</td>
                <td>Age ...................... rrs</td>
            </tr>
            <tr>
                <td>บัตรประชาชนเลขที่ ..................................</td>
            </tr>
            <tr>
                <td>Identity card no.</td>
            </tr>
        </table>

        <table style="width:100%;">
            <tr>
                <td>บ้านเลขที่..............</td>
                <td>หมูที่ ..............</</td>
                <td>ถนน ..............</</td>
                <td>ตำบล/แขวง ..............</</td>
            </tr>
            <tr>
                <td>Present address</td>
                <td>Moo</td>
                <td>Road</td>
                <td>Disteict</td>
            </tr>
            <tr>
                <td>อำเภอ/เขต ..............</</td>
                <td>จังหวัด ..............</</td>
            </tr>
            <tr>
                <td></td>
                <td>รหัสไปรษณีย์ ..............</</td>
            </tr>
            <tr>
                <td>Amphur</td>
                <td>Province</td>
                <td>Post code</td>
            </tr>
            <tr>
                <td>เบอร์โทรศัพท์ ..............</</td>
            </tr>
            <tr>
                <td>Tel.</td>
            </tr>
            <tr>
                <td>อีเมล์ ..............</</td>
            </tr>
            <tr>
                <td>E-mail</td>
            </tr>
            <tr>
                <td>ชื่อร้านค้า ..............</</td>
            </tr>
            <tr>
                <td>Store</td>
            </tr>
            <tr>
                <td>สินค้าที่จำหน่าย ..............</</td>
            </tr>
            <tr>
                <td>Product</td>
            </tr>
        </table>
        <table style="width:100%;text-align: center;">
            <tr>
                <td></td>
                <td>ข้าพเจ้าขอรับว่า ข้อความดังกล่าวทั้งหมดต้นนี้เป็นความจริงทุกประการ</td>
                <td></td>
            </tr>
        </table>
        <table>
            <tr>
                <td></td>
                <td></td>
                <td>...........................................
                    <br>ลายมือชื่อผู้ประกอบการ
                    <br>(Appficants stgnaturg)
                    <br>............../............./............
                </td>
            </tr>
        </table>
        <!-- End of your content -->
    </div>
</body>

</html>