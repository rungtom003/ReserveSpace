<?php
date_default_timezone_set("Asia/Bangkok");
include("./layout/static_path.php");
session_start();
$user = (isset($_SESSION['user'])) ? unserialize($_SESSION['user']) : null;
$startDate = (isset($_SESSION['os_StartDateTime'])) ? $_SESSION['os_StartDateTime'] : null;
$EndDate = (isset($_SESSION['os_EndDateTime'])) ? $_SESSION['os_EndDateTime'] : null;
$u_Id = $_GET["u_Id"];

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
                /* outline: thin dashed black; */
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
                <td><span id="z_Name"></span> </td>
                <td rowspan="3" style="position: absolute;top: 100px; right: 80px;"><img height="151px" width="113px" id="u_Img"></img></td>
            </tr>
            <tr>
                <td></td>
                <td>ประวัติผู้ประกอบการถนนคนเดินขอนแก่น
                    <br>เทศบาลขอนแก่น
                </td>
                <td></td>
            </tr>
        </table>
        <table style="width:100%;">
            <tr>
                <td>รหัส Walk in : <span id="u_IdWalkin"></span></td>
            </tr>
            <tr>
                <td>ชื่อ-สกุล : <span id="u_FullName"></span></td>
            </tr>
        </table>
        <table style="width:100%;margin-bottom: 20px;">
            <tr>
                <td>Name-Sumane</td>
            </tr>
            <tr>
                <td>วัน เดือน ปีเกิด : <span id="u_Birthday"></span></td>
                <td>อายุ <span id="u_Ageth"></span> ปี</td>
            </tr>
            <tr>
                <td>Date of brith</td>
                <td>Age <span id="u_Ageen"></span> years</td>
            </tr>
            <tr>
                <td>บัตรประชาชนเลขที่ : <span id="u_CardNumber"></span></td>
            </tr>
            <tr>
                <td>Identity card no.</td>
            </tr>
        </table>

        <table style="width:100%;margin-bottom: 20px;">
            <tr>
                <td>ที่อยู่ : <span id="u_Address"></span></td>
                <td>ถนน : <span id="u_Road"></span></td>
                <td>ตำบล/แขวง : <span id="u_SubDistrict"></span></td>
            </tr>
            <tr>
                <td>address</td>
                <td>Road</td>
                <td>Disteict</td>
            </tr>
            <tr>
                <td>อำเภอ/เขต : <span id="u_District"></span></td>
                <td>จังหวัด : <span id="u_Province"></span></td>
                <td>รหัสไปรษณีย์ : <span id=""></span></td>
            </tr>
            <tr>
                <td>Amphur</td>
                <td>Province</td>
                <td>Post code</td>
            </tr>
        </table>

        <table style="width:100%;margin-bottom: 20px;">
            <tr>
                <td>เบอร์โทรศัพท์ : <span id="u_Phone"></span></td>
            </tr>
            <tr>
                <td>Tel.</td>
            </tr>
            <tr>
                <td>อีเมล์ : <span id=""></span></td>
            </tr>
            <tr>
                <td>E-mail</td>
            </tr>
            <tr>
                <td>ชื่อร้านค้า : <span id="u_ShopName"></span></td>
            </tr>
            <tr>
                <td>Store</td>
            </tr>
            <tr>
                <td>สินค้าที่จำหน่าย : <span id="u_ProductName"></span></td>
            </tr>
            <tr>
                <td>Product</td>
            </tr>
        </table>

        <table style="width:100%;text-align: center;">
            <tr>
                <td></td>
                <td>ข้าพเจ้าขอรับรองว่า ข้อความดังกล่าวทั้งหมดข้างต้นนี้เป็นความจริง</td>
                <td></td>
            </tr>
        </table>

        <table style="width: 100%;">
            <tr style="width: 100%;">
                <td style="display: flex; flex-direction: row; align-items: center; justify-content: flex-end ;width: 90%;">
                    <div style="display: flex;flex-direction: column;align-items: center;">
                        <br><br><br><br>
                        <span id="u_FullNamesen"></span><br>
                        <span>ลายมือชื่อผู้ประกอบการ</span>
                        <span>(Appficants stgnaturg)</span>
                        <span id="nowdt"></span>
                    </div>
                </td>
            </tr>
        </table>
        <!-- End of your content -->
    </div>
    <?php include("./layout/script.php"); ?>
    <script>
        $.ajax({
            url: "<?= $host_path ?>/backend/Service/user_document.php",
            type: "post",
            dataType: "json",
            data: {
                u_Id: "<?= $u_Id ?>"
            },
            beforeSend: function() {

            },
            success: function(res) {
                const data = res.data;
                console.log(data)
                if (res.status === "success") {
                    $("#u_IdWalkin").html(data.u_IdWalkin);
                    $("#u_FullName").html(`${data.u_FirstName} ${data.u_LastName}`);
                    $("#z_Name").html(data.z_Name);
                    $("#u_Birthday").html(moment(data.u_Birthday).format("DD/MM/YYYY"));
                    $("#u_Ageth").html(moment().diff(data.u_Birthday, 'years'));
                    $("#u_Ageen").html(moment().diff(data.u_Birthday, 'years'));
                    $("#u_CardNumber").html(data.u_CardNumber);
                    $("#u_SubDistrict").html(data.u_SubDistrict);
                    $("#u_District").html(data.u_District);
                    $("#u_Province").html(data.u_Province);
                    $("#u_Phone").html(data.u_Phone);
                    $("#u_ShopName").html(data.u_ShopName);
                    $("#u_ProductName").html(data.u_ProductName);
                    $("#u_FullNamesen").html(`${data.u_FirstName} ${data.u_LastName}`);
                    $("#nowdt").html(moment().format("DD/MM/YYYY"));
                    $("#u_Address").html(data.u_Address);
                    $("#u_Road").html(data.u_Road);
                    if (data.u_Img !== "") {
                        $("#u_Img").attr('src', `<?= $host_path ?>/src/img/upload/${data.u_Img}`);
                    }

                } else {

                }
            }
        });
    </script>
</body>

</html>