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

$titleHead = "ตั้งค่าเวลา เปิด-ปิด ระบบ";
$active_opensystem = "active";
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $titleHead ?></title>
    <?php include("./layout/css.php"); ?>
</head>

<body style="font-family: kanit-Regular;">
    <?php include("./layout/head.php"); ?>
    <!-- start: Main -->
    <main class="bg-light">
        <div class="p-2">
            <?php include("./layout/navmain.php"); ?>
            <div class="py-2" style="font-family: kanit-Regular;">
                <div class="card my-2">
                    <div class="card-body">
                        <div>
                            <h1 id="time-open"></h1>
                            <h1 id="time-close"></h1>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="my-3 d-flex align-items-center flex-column">
                            <h1>ตั้งเวลา เปิด/ปิด ระบบ</h1>
                            <input class="form-control text-center" type="text" name="daterange" id="daterange" value="" />
                            <button class="btn btn-primary my-2" id="btn-save" onclick="savebtn()">บันทึก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- end: Main -->
    <?php include("./layout/script.php"); ?>
    <script>
        $('#daterange').daterangepicker({
            "timePicker": true,
            "timePicker24Hour": true,
            locale: {
                format: 'DD/MM/YYYY HH:mm:ss'
            }
        });
        const savebtn = () => {
            let os_StartDateTime = $('input[name="daterange"]').data('daterangepicker').startDate.format("YYYY-MM-DD HH:mm:ss");
            let os_EndDateTime = $('input[name="daterange"]').data('daterangepicker').endDate.format("YYYY-MM-DD HH:mm:ss");

            const data = {
                os_StartDateTime: os_StartDateTime,
                os_EndDateTime: os_EndDateTime
            }

            $.ajax({
                url: "<?= $host_path ?>/backend/Service/settime_open_system.php",
                type: "post",
                dataType: "json",
                data: data,
                success: function(res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: true,
                            timer: 1500
                        }).then((result) => {
                            window.location.reload();
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: true,
                            timer: 1500
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                }
            })
        }

        document.getElementById("time-open").innerHTML = `เวลาเปิดระบบ : ${moment("<?=$_SESSION["os_StartDateTime"]?>").format('DD/MM/YYYY HH:mm:ss')}`;
        document.getElementById("time-close").innerHTML = `เวลาปิดระบบ : ${moment("<?=$_SESSION["os_EndDateTime"]?>").format('DD/MM/YYYY HH:mm:ss')}`;
    </script>
</body>

</html>